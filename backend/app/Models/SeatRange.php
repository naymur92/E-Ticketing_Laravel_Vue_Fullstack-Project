<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeatRange extends Model
{
  use HasFactory;

  public function schedule()
  {
    return $this->belongsTo(related: Schedule::class);
  }

  public function bogi()
  {
    return $this->belongsTo(related: Bogi::class);
  }
}
