<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperActivity
 */
class Activity extends \Spatie\Activitylog\Models\Activity
{
    public function getArabicEvent(): ?string
    {
        if ($this->event == 'created') {
            return 'إنشاء';
        }
        if ($this->event == 'updated') {
            return 'تعديل';
        }
        if ($this->event == 'deleted') {
            return 'حذف';
        }
        return $this->event;
    }

    public function getSubjectInfoString()
    {
        if ($this->subject instanceof Order){
            return "طلب رقم {$this->subject->order_id} تسلسل {$this->subject->id}";
        }
        if ($this->subject instanceof Account){
            return "حساب رقم {$this->subject->profile} تسلسل{$this->subject->id}";
        }
        if ($this->subject instanceof Group){
            return "اسم الميجموعة {$this->subject->name}  تسلسل{$this->subject->id}";
        }

        return "";
    }
}
