<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePersonRequest;
use App\Http\Requests\CreateRelationRequest;
use App\Http\Requests\LoadPersonRequest;
use App\Models\Image;
use App\Models\Note;
use App\Models\Person;
use App\Models\Relation;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;

class PersonController extends Controller
{
    public function create(CreatePersonRequest $request) {
        try {
            $person = new Person();
            $person->user_id = Auth::id() ?? User::DEFAULT_USER;
            $person->name = $request->get('personName');
            $person->faction_id = $request->get('faction');
            $person->save();

            if($request->get('notes') != null) {
                $note = new Note();
                $note->person_id = $person->id;
                $note->text = $request->get('notes');
                $note->save();
            }

            if($request->file('picture') != null) {
                $images = $request->file('picture');

                if (is_array($images)) {
                    foreach ($images as $image) {
                        $filename = uniqid() . '.' . $image->getClientOriginalExtension();
                        $image->move(public_path('images'), $filename);

                        $imageDB = new Image();
                        $imageDB->person_id = $person->id;
                        $imageDB->url = $filename;
                        $imageDB->save();
                    }
                } else {
                    $filename = uniqid() . '.' . $images->getClientOriginalExtension();
                    $images->move(public_path('images'), $filename);

                    $imageDB = new Image();
                    $imageDB->person_id = $person->id;
                    $imageDB->url = $filename;
                    $imageDB->save();
                }
            }

            return json_encode(["success" => true, "id" => $person->id, "name" => $person->name]);
        } catch(Exception $e) {
            return json_encode(["success" => false]);
        }
    }

    public function createRelation(CreateRelationRequest $request) {
        try {
            $relation = new Relation();
            $relation->person_id = $request->get('personOriginal');
            $relation->related_person_id = $request->get('personLinked');
            $relation->relation_type_id = $request->get('relation');
            $relation->save();

            return json_encode(["success" => true]);
        } catch(Exception $e) {
            return json_encode(["success" => false]);
        }
    }

    public function load(LoadPersonRequest $request) {
        try {
            $details = Person::with(['faction', 'notes', 'images'])->where("id", $request->get('id'))->first();
            return json_encode(["success" => true, "details" => $details]);
        } catch(Exception $e) {
            return abort(500);
        }
    }
}
