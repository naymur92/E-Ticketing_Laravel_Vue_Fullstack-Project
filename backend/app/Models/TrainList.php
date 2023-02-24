<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainList extends Model
{
  use HasFactory;

  protected $fillable = ['train_name', 'off_day', 'up_down'];

  public function routes()
  {
    return $this->hasMany(related: Route::class, foreignKey: 'route_id');
  }

  public function trains()
  {
    return $this->hasMany(related: Train::class, foreignKey: 'route_id');
  }
}
