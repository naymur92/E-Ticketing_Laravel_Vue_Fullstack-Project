<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bogi extends Model
{
  use HasFactory;

  protected $fillable = ['bogi_name', 'train_id', 'bogi_type_id'];

  public function bogi_type()
  {
    return $this->belongsTo(related: BogiType::class);
  }

  public function train()
  {
    return $this->belongsTo(related: Train::class);
  }

  public function seats()
  {
    return $this->hasMany(related: Seat::class, foreignKey: 'bogi_id');
  }

  public function seat_range()
  {
    return $this->hasMany(related: SeatRange::class, foreignKey: 'bogi_id');
  }
}
