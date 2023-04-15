<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RelationType extends Model
{
    protected $table = 'relations_type';
    protected $primaryKey = 'id';

    protected $fillable = [
        'label',
    ];

    public function relations()
    {
        return $this->hasMany(Relation::class);
    }
}
