<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class itams_devices extends Model
{
    use HasFactory;
    protected $fillable = [
        'serial_number',
        'status_id',
        'branch_id',
        'accossories',
        'notes',
        'class_id',
        'category_id',
        'model_id',
        'employee_id',
        'processor_id',
        'memory1_id',
        'memory2_id',
        'hard_disk1_id',
        'hard_disk2_id',
    ];

    public function class() { 
        return $this->belongsTo(itams_classes::class);
    }

    public function category() { 
        return $this->belongsTo(itams_categories::class);
    }

    public function model() { 
        return $this->belongsTo(itams_models::class);
    }

    public function employee() { 
        return $this->belongsTo(itams_employees::class,'employee_id');
    }

    public function processor() { 
        return $this->belongsTo(itams_processors::class);
    }

    public function memory1() { 
        return $this->belongsTo(itams_memories::class,'memory1_id');
    }

    public function memory2() { 
        return $this->belongsTo(itams_memories::class,'memory2_id');
    }

    public function hard_disk1() { 
        return $this->belongsTo(itams_hard_disks::class,'hard_disk1_id');
    }

    public function hard_disk2() { 
        return $this->belongsTo(itams_hard_disks::class,'hard_disk2_id');
    }

    public function branch() { 
        return $this->belongsTo(itams_branches::class);
    }

    public function status() { 
        return $this->belongsTo(itams_statuses::class);
    }

    public function dates() {
        return $this->hasMany(itams_dates::class);
    }

}
