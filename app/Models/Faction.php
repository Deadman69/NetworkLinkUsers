<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Faction extends Model
{
    protected $table = 'factions';
    protected $primaryKey = 'id';

    protected $fillable = [
        'label',
    ];

    public function persons()
    {
        return $this->hasMany(Person::class);
    }
}
