<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class processors extends Model
{
    use HasFactory;
    protected $fillable = ['processor'];

    public function device() {
        return $this->hasMany(devices::class);
    }

}
