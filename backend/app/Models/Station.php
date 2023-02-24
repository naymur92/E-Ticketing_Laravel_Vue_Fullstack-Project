<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Station extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'address', 'lat', 'lon'];

    public function routes()
    {
        return $this->hasMany(related: Route::class, foreignKey: 'station_id');
    }

    public function schedules()
    {
        return $this->hasMany(related: Schedule::class, foreignKey: 'from_station_id');
    }

    public function tickets()
    {
        return $this->hasMany(related: Ticket::class, foreignKey: 'station_from');
    }
}
