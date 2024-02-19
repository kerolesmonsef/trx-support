<?php

namespace App\Trait;

use App\Models\ComplainType;

trait ComplainTypeComponentTrait
{
    public $complain_type_name = '';
    public $complain_type_id = '';

    public $complain_type_type = 'account';

    public function saveComplainType()
    {
        $this->validate([
            'complain_type_name' => 'required|min:3|max:255',
        ],[
            'complain_type_name.required' => 'اسم النوع مطلوب',
        ]);

        if ($this->complain_type_id) {
            ComplainType::find($this->complain_type_id)->update([
                'name' => $this->complain_type_name,
                'type' => $this->complain_type_type,
            ]);
        } else {
            ComplainType::create([
                'name' => $this->complain_type_name,
                'type' => $this->complain_type_type,
            ]);
        }
        $this->complain_type_name = '';
        $this->complain_type_id = '';
        session()->flash("message", "تم حفظ نوع المشكلة بنجاح");
    }

    public function editComplainType($id)
    {
        $complain_type = ComplainType::find($id);
        $this->complain_type_name = $complain_type->name;
        $this->complain_type_id = $complain_type->id;
        $this->complain_type_type = $complain_type->type;
    }

    public function deleteComplainType($id)
    {
        ComplainType::find($id)->delete();
        $this->complain_type_name = '';
        $this->complain_type_id = '';
        $this->complain_type_type = 'account';
        session()->flash("message", "تم حذف نوع المشكلة بنجاح");
    }

    public function cancelComplainType()
    {
        $this->complain_type_name = '';
        $this->complain_type_id = '';
        $this->complain_type_type = 'account';
        session()->flash("message", "تم الغاء العملية بنجاح");
    }
}
