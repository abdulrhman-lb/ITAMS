<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sub_branches extends Model 
{
    use HasFactory;
    protected $fillable = ['branch_id','sub_branch','sub_branch_en'];

            // تعريف العلاقة مع الجدول الفرعي (comments)
            public function comments()
            {
                return $this->hasMany(employees::class,'sub_branch_id');
            }
        
            // دالة للتحقق من إمكانية حذف السجل
            public function canDelete()
            {
                return !$this->comments()->exists();
            }

    public function branch() { 
        return $this->belongsTo(branches::class);
    }

    public function employee() {
        return $this->hasMany(employees::class);
    }

    public function dates() {
        return $this->hasMany(dates::class);
    }
}
