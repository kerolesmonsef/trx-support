<?php

namespace App\Livewire;

use App\Helpers\AccountService;
use App\Models\Account;
use App\Models\Group;
use App\Models\Order;
use App\Trait\SaveAccountTrait;
use App\Trait\UpdateOrderCanTicketTrait;
use DB;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;

class Accounts extends Component
{
    use WithPagination, UpdateOrderCanTicketTrait, SaveAccountTrait;

    protected $paginationTheme = 'bootstrap';
    public $search = '';
    public $group_id = null; // if update
    public $name = "";
    public $username = "";
    public $password = "";
    public $description = "";


    public $seen_type = 'all';
    public $ended_profile_filter = "all";

    protected $listeners = [
        DuplicatedAccountIdModal::ACCEPT_EVENT_NAME => 'acceptDuplicatedAccountId',
    ];

    public function render()
    {
        $groups = $this->getGroups();
        return view('livewire.accounts', [
            'groups' => $groups,
        ]);
    }

    public function getGroups()
    {
        $query = Group::query()
            ->with("accounts.order")
            ->withCount("accounts")
            ->orderBy('id', 'desc')
            ->where(function (Builder $query) {
                $query->where("name", "like", "%{$this->search}%")
                    ->orWhere("username", "like", "%{$this->search}%")
                    ->orWhereHas("accounts", function (Builder $query) {
                        $query->where("profile", "like", "%{$this->search}%");
                    })
                    ->orWhereHas("accounts.order", function (Builder $query) {
                        $query
                            ->where("orders.order_id", "like", "%{$this->search}%")
                            ->orWhere("orders.secure_phone", "like", "%{$this->search}%");
                    });
            });

        if ($this->seen_type == "seen") {
            $query->whereHas("accounts.order", function (Builder $query) {
                $query->whereNotNull('seen_at');
            });
        } elseif ($this->seen_type == "unseen") {
            $query->whereHas("accounts.order", function (Builder $query) {
                $query->whereNull('seen_at');
            });
        }

        if ($this->ended_profile_filter == "ended") {
            $query->whereHas("accounts", function (Builder $query) {
                $query->whereDate('subscription_expire_at', "<", now());
            });
        }
        if ($this->ended_profile_filter == "unended") {
            $query->whereHas("accounts", function (Builder $query) {
                $query->whereDate('subscription_expire_at', ">=", now());
            });
        }

        return $query->paginate();
    }

    public function removeGroup($id): void
    {
        Group::find($id)?->delete();
        session()->flash('message', 'تم مسح المجموعة بنجاح');
    }

    private function clearData(): void
    {
        $this->accounts_array = [];
        $this->group_id = null;
        $this->name = "";
        $this->description = "";
        $this->username = "";
        $this->password = "";

        $this->resetErrorBag();
    }

    public function cancel(): void
    {
        $this->clearData();
    }

}
