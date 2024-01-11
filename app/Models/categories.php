<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class categories extends Model
{
    use HasFactory;
    protected $fillable = ['class_id','category'];

        // تعريف العلاقة مع الجدول الفرعي (comments)
        public function comments()
        {
            return $this->hasMany(models::class,'category_id');
        }
    
        // دالة للتحقق من إمكانية حذف السجل
        public function canDelete()
        {
            return !$this->comments()->exists();
        }
    
    public function class() { 
        return $this->belongsTo(classes::class);
    }
    public function model() {
        return $this->hasMany(models::class);
    }

    public function device() {
        return $this->hasMany(devices::class);
    }
}