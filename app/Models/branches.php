<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class branches extends Model
{
    use HasFactory;
    protected $fillable = ['branch','branch_en'];

        // تعريف العلاقة مع الجدول الفرعي (comments)
        public function comments()
        {
            return $this->hasMany(sub_branches::class,'branch_id');
        }
    
        // دالة للتحقق من إمكانية حذف السجل
        public function canDelete()
        {
            return !$this->comments()->exists();
        }

    public function sub_branch() {
        return $this->hasMany(sub_branches::class);
    }

    public function user() {
        return $this->hasMany(user::class);
    }

    public function employee() {
        return $this->hasMany(employees::class);
    }

    public function device() {
        return $this->hasMany(devices::class);
    }

    public function dates() {
        return $this->hasMany(dates::class);
    }
}
