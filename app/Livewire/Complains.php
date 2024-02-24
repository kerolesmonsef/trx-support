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
    public $type = '';


    public function render()
    {
        return view('livewire.complains', [
            'complains' => $this->getComplains(),
            'complain_types' => ComplainType::all(),
        ]);
    }

    private function getComplains(): LengthAwarePaginator
    {
        $query = OrderComplain::query()
            ->with(["order", 'type', 'lastUpdatedUser', 'assignee'])
            ->when($this->status, function (Builder $builder) {
                $builder->where('order_complains.status', $this->status);
            })
            ->when($this->type, function (Builder $builder) {
                $builder->where('order_complains.complain_type_id', $this->type);
            })
            ->when($this->search, function (Builder $builder) {
                $builder->where("description", "LIKE", "%{$this->search}%")
                    ->orWhere("order_id", "LIKE", "%{$this->search}%")
                    ->orWhere("code", "LIKE", "%{$this->search}%")
                    ->orWhereHas("order", function (Builder $builder) {
                        $builder->where("orders.order_id", "LIKE", "%{$this->search}%");
                    });
            })
            ->latest();

        if (!auth()->user()->hasRole('admin')) {
            $query->where("assigned_user_id", auth()->id());
        }

        return $query->paginate();
    }


}
