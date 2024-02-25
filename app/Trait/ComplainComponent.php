<?php

namespace App\Trait;

use App\Models\OrderComplain;

trait ComplainComponent
{
    public ?OrderComplain $orderComplain = null;
    public int|null $assignee_id = null;
    public string|null $complain_answer = null;

    public function showComplain($order_complain_id)
    {
        $this->orderComplain = OrderComplain::find($order_complain_id);
        $this->assignee_id = $this->orderComplain->assigned_user_id;
        $this->complain_answer = $this->orderComplain->complain_answer;
    }

    public function deleteComplain($order_complain_id)
    {
        OrderComplain::find($order_complain_id)->delete();
        $this->orderComplain = null;
    }

    public function updateStatus($status)
    {
        $this->orderComplain->update([
            'status' => $status,
            'last_updated_user_id' => auth()->id()
        ]);
        session()->flash('message', "تم تحديث الحالة بنجاح");
    }

    public function updateAnswer()
    {
        $this->orderComplain->update([
            'complain_answer' => $this->complain_answer,
            'last_updated_user_id' => auth()->id()
        ]);
        session()->flash('message', "تم تحديث الإجابة بنجاح");
    }
    public function updateAssignee(): void
    {
        $this->orderComplain->update([
            'assigned_user_id' => $this->assignee_id ?: null,
        ]);
        session()->flash('message', "تم تحديث الموظف بنجاح");
    }

}
