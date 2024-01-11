<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class hard_disks extends Model
{
    use HasFactory;
    protected $fillable = ['kind','size'];

    public function device() {
        return $this->hasMany(devices::class);
    }

}
