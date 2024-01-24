<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class itams_models extends Model
{
    use HasFactory;
    protected $fillable = ['category_id','model','image'];

    public function category() {
        return $this->belongsTo(itams_categories::class);
    }

    public function device() {
        return $this->hasMany(itams_devices::class);
    }
}
