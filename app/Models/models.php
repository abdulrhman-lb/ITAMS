<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class models extends Model
{
    use HasFactory;
    protected $fillable = ['category_id','model','image'];

    public function category() {
        return $this->belongsTo(categories::class);
    }

    public function device() {
        return $this->hasMany(devices::class);
    }
}
