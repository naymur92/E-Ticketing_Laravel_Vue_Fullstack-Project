<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seat extends Model
{
  use HasFactory;

  protected $fillable = ['seat_name', 'bogi_id', 'booked'];

  public function bogi()
  {
    return $this->belongsTo(related: Bogi::class);
  }

  public function ticket()
  {
    return $this->hasOne(related: Ticket::class, foreignKey: 'seat_id');
  }
}
