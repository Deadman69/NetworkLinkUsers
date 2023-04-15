<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Relation extends Model
{
    protected $table = 'relations';
    protected $primaryKey = 'id';

    protected $fillable = ['person_id', 'related_person_id', 'relation_type_id'];

    public function person()
    {
        return $this->belongsTo('App\Models\Person');
    }

    public function relatedPerson()
    {
        return $this->belongsTo('App\Models\Person', 'related_person_id');
    }

    public function relationType()
    {
        return $this->belongsTo('App\Models\RelationType', 'relation_type_id');
    }
}
