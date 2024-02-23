<?php

namespace App\Livewire;

use App\Models\Account;
use App\Models\Activity;
use App\Models\Group;
use App\Models\Order;
use Illuminate\Contracts\Pagination\CursorPaginator;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;
use LivewireUI\Modal\ModalComponent;

class ShowGroupActivities extends ModalComponent
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';


    public Group $group;

    public function mount($group_id)
    {
        $this->group = Group::find($group_id);
    }

    public static function modalMaxWidth(): string
    {
        return '7xl';
    }

    public function render()
    {
        return view('livewire.show-group-activities', [
            'activities' => $this->getActivities()
        ]);
    }

    /**
     */
    private function getActivities()
    {
        $account_ids = $this->group->accounts->pluck("id");
        $order_ids = $this->group->accounts->pluck("order_id");

        return Activity::query()
            ->with("subject","causer")
            //->whereNotNull(['causer_type', 'causer_id'])
            ->where(function (Builder $query) {
                $query->where('subject_type', Group::class)
                    ->where('subject_id', $this->group->id);
            })->orWhere(function (Builder $query) use ($order_ids) {
                $query->where("subject_type", Order::class)
                    ->whereIn("subject_id", $order_ids);
            })->orWhere(function (Builder $query) use ($account_ids) {
                $query->where("subject_type", Account::class)
                    ->whereIn("subject_id", $account_ids);
            })
            ->orderByDesc("id",)
            ->simplePaginate();
    }
}
