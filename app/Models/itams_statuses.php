<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class itams_statuses extends Model
{
    use HasFactory;
    protected $fillable = ['status'];

        // تعريف العلاقة مع الجدول الفرعي (comments)
        public function comments()
        {
            return $this->hasMany(itams_devices::class,'status_id');
        }

        // دالة للتحقق من إمكانية حذف السجل
        public function canDelete()
        {
            return !$this->comments()->exists();
        }


    public function device() {
    return $this->hasMany(itams_devices::class);
    }
}
