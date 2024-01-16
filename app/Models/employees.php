<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class employees extends Model
{
    use HasFactory;
    protected $fillable = ['branch_id','sub_branch_id','department_id','full_name','jop_title_id','phone','mobile','email','ena'];

        // تعريف العلاقة مع الجدول الفرعي (comments)
        public function comments()
        {
            return $this->hasMany(devices::class,'employee_id');
        }
    
        // دالة للتحقق من إمكانية حذف السجل
        public function canDelete()
        {
            return !$this->comments()->exists();
        }

    public function branch() { 
        return $this->belongsTo(branches::class);
    }

    public function sub_branch() { 
        return $this->belongsTo(sub_branches::class);
    }

    public function department() { 
        return $this->belongsTo(departments::class);
    }

    public function jop_title() { 
        return $this->belongsTo(jop_titles::class);
    }

    public function device() {
        return $this->hasMany(devices::class);
    }

    public function dates() {
        return $this->hasMany(dates::class);
    }

}
