<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class itams_jop_titles extends Model
{
    use HasFactory;
    protected $fillable = ['jop_title'];

            // تعريف العلاقة مع الجدول الفرعي (comments)
            public function comments()
            {
                return $this->hasMany(itams_employees::class,'jop_title_id');
            }
        
            // دالة للتحقق من إمكانية حذف السجل
            public function canDelete()
            {
                return !$this->comments()->exists();
            }
    

    public function employee() {
        return $this->hasMany(itams_employees::class);
    }
}
