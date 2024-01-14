<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class dates extends Model
{
    use HasFactory;
    protected $fillable = [
        'branch_id',
        'sub_branch_id',
        'department_id',
        'employee_id',
        'device_id',
        'start_date',
        'end_date'
    ];

    public function branch() { 
        return $this->belongsTo(branches::class);
    }
    
    public function sub_branch() { 
        return $this->belongsTo(sub_branches::class);
    }
    
    public function department() { 
        return $this->belongsTo(departments::class);
    }
    
    public function employee() { 
        return $this->belongsTo(employees::class);
    }
    
    public function device() { 
        return $this->belongsTo(devices::class);
    }
    
}
