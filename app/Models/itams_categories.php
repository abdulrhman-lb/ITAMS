<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class itams_categories extends Model
{
    use HasFactory;
    protected $fillable = ['class_id','category'];

        // تعريف العلاقة مع الجدول الفرعي (comments)
        public function comments()
        {
            return $this->hasMany(itams_models::class,'category_id');
        }
    
        // دالة للتحقق من إمكانية حذف السجل
        public function canDelete()
        {
            return !$this->comments()->exists();
        }
    
    public function class() { 
        return $this->belongsTo(itams_classes::class);
    }
    public function model() {
        return $this->hasMany(itams_models::class);
    }

    public function device() {
        return $this->hasMany(itams_devices::class);
    }
}