<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class itams_employees extends Model
{
    use HasFactory;
    protected $fillable = ['branch_id','sub_branch_id','department_id','full_name','jop_title_id','phone','mobile','email','ena'];

        // تعريف العلاقة مع الجدول الفرعي (comments)
        public function comments()
        {
            return $this->hasMany(itams_devices::class,'employee_id');
        }
    
        // دالة للتحقق من إمكانية حذف السجل
        public function canDelete()
        {
            return !$this->comments()->exists();
        }

    public function branch() { 
        return $this->belongsTo(itams_branches::class);
    }

    public function sub_branch() { 
        return $this->belongsTo(itams_sub_branches::class);
    }

    public function department() { 
        return $this->belongsTo(itams_departments::class);
    }

    public function jop_title() { 
        return $this->belongsTo(itams_jop_titles::class);
    }

    public function device() {
        return $this->hasMany(itams_devices::class);
    }

    public function dates() {
        return $this->hasMany(itams_dates::class);
    }

}
