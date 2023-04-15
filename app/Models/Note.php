<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    protected $table = 'notes';
    protected $primaryKey = 'id';

    protected $fillable = ['content', 'person_id'];

    public function person()
    {
        return $this->belongsTo('App\Models\Person');
    }
}
