<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    public function train()
    {
        return $this->belongsTo(related: Train::class);
    }

    public function user()
    {
        return $this->belongsTo(related: User::class);
    }

    public function station_from()
    {
        return $this->belongsTo(related: Station::class, foreignKey: 'station_from');
    }

    public function station_to()
    {
        return $this->belongsTo(related: Station::class, foreignKey: 'station_to');
    }

    public function seat()
    {
        return $this->belongsTo(related: Seat::class, foreignKey: 'seat_id');
    }
}
