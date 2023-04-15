<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    protected $table = 'persons';
    protected $primaryKey = 'id';

    protected $fillable = ['user_id', 'name', 'faction_id'];

    public function images()
    {
        return $this->hasMany('App\Models\Image');
    }

    public function relatedPersons()
    {
        return $this->belongsToMany('App\Models\Person', 'relations', 'person_id', 'related_person_id')->withPivot('type');
    }

    public function notes()
    {
        return $this->hasMany('App\Models\Note');
    }

    public function faction()
    {
        return $this->belongsTo('App\Models\Faction');
    }
}
