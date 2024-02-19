<?php

namespace App\Livewire;

use App\Models\ComplainType;
use App\Models\OrderComplain;
use App\Trait\ComplainComponent;
use App\Trait\ComplainTypeComponentTrait;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;

class Complains extends Component
{
    use ComplainTypeComponentTrait,
        ComplainComponent;

    protected $paginationTheme = 'bootstrap';
    public $search = '';
    public $status = '';


    public function render()
    {
        return view('livewire.complains', [
            'complains' => $this->getComplains(),
            'complain_types' => ComplainType::all(),
        ]);
    }

    private function getComplains(): LengthAwarePaginator
    {
        return OrderComplain::query()
            ->with("order")
            ->latest()
            ->when($this->status, function (Builder $builder) {
                $builder->where('order_complains.status', $this->status);
            })
            ->where("description", "LIKE", "%{$this->search}%")
            ->paginate();
    }


}
