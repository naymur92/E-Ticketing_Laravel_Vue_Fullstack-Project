<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BogiType extends Model
{
    use HasFactory;

    protected $fillable = ['bogi_type_name', 'seat_count'];

    public function bogis()
    {
        return $this->hasMany(related: Bogi::class, foreignKey: 'bogi_type_id');
    }
}
