<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function sources()
    {

        return $this->hasMany(DirectLine::class, 'destination_city_id');
    }

    public function destinations()
    {

        return $this->hasMany(DirectLine::class, 'source_city_id');
    }
}
