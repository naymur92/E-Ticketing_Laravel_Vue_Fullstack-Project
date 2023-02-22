<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
  use HasFactory;

  protected $fillable = ['train_id', 'from_station_id', 'to_station_id', 'left_station_at', 'reach_destination_at', 'ac_b_price', 'ac_s_price', 'snigdha_price', 'f_berth_price', 'f_seat_price', 'f_chair_price', 's_chair_price', 'shovon_price'];

  public function train()
  {
    return $this->belongsTo(related: Train::class);
  }
}
