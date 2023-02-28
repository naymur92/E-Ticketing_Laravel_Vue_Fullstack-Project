<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Train extends Model
{
  use HasFactory;

  protected $fillable = ['name', 'journey_date', 'route_id', 'created_at'];

  public function bogis()
  {
    return $this->hasMany(related: Bogi::class, foreignKey: 'train_id');
  }

  public function route()
  {
    // call $train->route->routes to get route list
    return $this->belongsTo(TrainList::class, 'route_id');
  }

  public function schedules()
  {
    return $this->hasMany(related: Schedule::class, foreignKey: 'train_id');
  }

  public function tickets()
  {
    return $this->hasMany(related: Ticket::class, foreignKey: 'train_id');
  }
}
