<?php

namespace App\Livewire;

use App\Models\Group;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;

class DuplicatedAccountIdModal extends ModalComponent
{
    public $orderIds;
    public $action;
    public $username;

    const ACCEPT_EVENT_NAME = 'duplicated-account-id-modal.accept';

    public function mount($orderIds, $action, $username)
    {
        $this->orderIds = $orderIds;
        $this->action = $action;
        $this->username = $username;
    }

    public static function modalMaxWidth(): string
    {
        return '7xl';
    }

    public function render()
    {
        return view('livewire.duplicated-account-id-modal');
    }

    public function accept(): void
    {
        $this->dispatch(self::ACCEPT_EVENT_NAME, [
            'action' => $this->action,
        ]);
        $this->closeModal();
    }

    public function cancel(): void
    {
        $this->closeModal();
    }
}


