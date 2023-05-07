<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePersonRequest;
use App\Http\Requests\CreateRelationRequest;
use App\Http\Requests\DeletePersonNoteRequest;
use App\Http\Requests\LoadPersonRequest;
use App\Http\Requests\UpdatePersonRequest;
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
            $relations = Relation::with(['person', 'relatedPerson', 'relationType'])->where('person_id', $details->id)->orWhere('related_person_id', $details->id)->get();
            return json_encode(["success" => true, "details" => $details, "relations" => $relations]);
        } catch(Exception $e) {
            return abort(500);
        }
    }

    public function update(UpdatePersonRequest $request) {
        try {
            $person = Person::where('id', $request->get('personIDDetails'))->first();
            if($person == null) {
                throw new Exception();
            }

            $person->name = $request->get('personNameDetails');
            $person->faction_id = $request->get('factionDetails');
            if($request->get('newNoteDetails') != null) {
                $newNote = new Note();
                $newNote->person_id = $person->id;
                $newNote->text = $request->get('newNoteDetails');
                $newNote->save();
            }
            $person->save();

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

            return json_encode(["success" => true]);
        } catch(Exception $e) {
            return json_encode(["success" => false]);
        }
    }

    public function deleteNote(DeletePersonNoteRequest $request) {
        try {
            $note = Note::where('id', $request->get('id'))->first();
            if($note == null) {
                throw new Exception();
            }

            $note->delete();

            return json_encode(["success" => true]);
        } catch(Exception $e) {
            return json_encode(["success" => false]);
        }
    }

    public function deleteRelation(DeletePersonNoteRequest $request) {
        try {
            $note = Relation::where('id', $request->get('id'))->first();
            if($note == null) {
                throw new Exception();
            }

            $note->delete();

            return json_encode(["success" => true]);
        } catch(Exception $e) {
            return json_encode(["success" => false]);
        }
    }
}
