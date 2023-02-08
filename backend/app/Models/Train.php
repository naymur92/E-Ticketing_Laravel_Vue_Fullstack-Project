<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Train extends Model
{
  use HasFactory;

  protected $fillable = ['name', 'date', 'product_price', 'home_station_id', 'start_time'];

  public function bogis()
  {
    return $this->hasMany(related: Bogi::class, foreignKey: 'train_id');
  }
}
