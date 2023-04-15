<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\Faction;
use App\Models\Person;
use App\Models\Relation;
use App\Models\RelationType;
use Illuminate\Support\Facades\Auth;

class DisplayController extends Controller
{
    public function display() {
        $persons = Person::all();
        $relations = Relation::all();
        $factions = Faction::all();
        $relations_type = RelationType::all();

        return view("pages.display", compact('persons', 'relations', 'factions', 'relations_type'));
    }
}
