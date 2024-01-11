<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class departments extends Model
{
    use HasFactory;
    protected $fillable = ['department','department_en'];

        // تعريف العلاقة مع الجدول الفرعي (comments)
        public function comments()
        {
            return $this->hasMany(employees::class,'department_id');
        }
    
        // دالة للتحقق من إمكانية حذف السجل
        public function canDelete()
        {
            return !$this->comments()->exists();
        }

    public function employee() {
        return $this->hasMany(employees::class);
    }

    public function device() {
        return $this->hasMany(devices::class);
    }

}
