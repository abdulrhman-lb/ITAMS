<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class itams_dates extends Model
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
        return $this->belongsTo(itams_branches::class);
    }
    
    public function sub_branch() { 
        return $this->belongsTo(itams_sub_branches::class);
    }
    
    public function department() { 
        return $this->belongsTo(itams_departments::class);
    }
    
    public function employee() { 
        return $this->belongsTo(itams_employees::class);
    }
    
    public function device() { 
        return $this->belongsTo(itams_devices::class);
    }
    
}
