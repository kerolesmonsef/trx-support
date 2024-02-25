<?php

namespace App\Livewire;

use App\Models\ComplainType;
use App\Models\Order;
use App\Models\OrderComplain;
use App\Trait\ComplainComponent;
use App\Trait\ComplainTypeComponentTrait;
use App\Trait\UpdateOrderCanTicketTrait;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;

class Complains extends Component
{
    use ComplainTypeComponentTrait,
        ComplainComponent,
        UpdateOrderCanTicketTrait;

    protected $paginationTheme = 'bootstrap';
    public $search = '';
    public $status = '';
    public $type = '';

    public function mount()
    {

    }

    public function render()
    {
        return view('livewire.complains', [
            'complains' => $this->getComplains(),
            'complain_types' => ComplainType::all(),
            'requestOrder' => request('order_id') ? Order::find(request('order_id')) : null,
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

        if (request('order_id')) {
            $query->where("order_id", request('order_id'));
        }


        return $query->paginate();
    }


}
