<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    use HasFactory;

    protected $fillable = ['route_id', 'station_id', 'time_from_prev_station', 'sl_no'];

    public function getTrain()
    {
        return $this->belongsTo(related: TrainList::class, foreignKey: 'route_id');
    }

    public function station()
    {
        return $this->belongsTo(related: Station::class, foreignKey: 'station_id');
    }

    // call $route->getTrain->trains to get trains list

    // public function trains()
    // {
    //     return $this->belongsToMany(related: Train::class, relatedPivotKey: 'route_id');
    // }
}
