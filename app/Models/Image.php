<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $table = 'images';
    protected $primaryKey = 'id';

    protected $fillable = [
        'filename',
        'person_id'
    ];

    public function person()
    {
        return $this->belongsTo('App\Models\Person');
    }
}
