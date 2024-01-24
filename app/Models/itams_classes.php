<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class itams_classes extends Model
{
    use HasFactory; 
    protected $fillable = ['class'];
        // تعريف العلاقة مع الجدول الفرعي (comments)
        public function comments()
        {
            return $this->hasMany(itams_categories::class,'class_id');
        }
    
        // دالة للتحقق من إمكانية حذف السجل
        public function canDelete()
        {
            return !$this->comments()->exists();
        }

    public function category() {
        return $this->hasMany(itams_categories::class);
    }

    public function device() {
        return $this->hasMany(itams_devices::class);
    }
}
