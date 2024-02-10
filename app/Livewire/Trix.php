<?php

namespace App\Livewire;

use Livewire\Component;

class Trix extends Component
{
    const EVENT_VALUE_UPDATED = 'trix_value_updated';

    public $value;
    public $trixId;

    protected $listeners = [
        'trix_clear_value' => 'trix_clear_value',
        'trix_set_value' => 'trix_set_value'
    ];

    public function mount($value = '')
    {
        $this->value = $value;
        $this->trixId = 'trix-' . uniqid();
    }

    public function updatedValue($value)
    {
        $this->dispatch(self::EVENT_VALUE_UPDATED, $this->value);
    }

    public function trix_clear_value()
    {
        $this->value = "";
    }

    public function trix_set_value($value)
    {
        $this->value = $value;
    }

    public function render()
    {
        return view('livewire.trix');
    }
}
