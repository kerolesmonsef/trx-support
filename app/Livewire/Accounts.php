<?php

namespace App\Livewire;

use App\Helpers\AccountService;
use App\Models\Account;
use App\Models\Group;
use App\Models\Order;
use DB;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;

class Accounts extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public $search = '';
    public $group_id = null; // if update
    public $name = "";
    public $username = "";
    public $password = "";
    public $description = "";
    public $accounts_array = [];

    public $listeners = [
        Trix::EVENT_VALUE_UPDATED // trix_value_updated()
    ];
    public $seen_type = 'all';


    public function trix_value_updated($value)
    {
        $this->description = $value;
    }


    public function render()
    {
        return view('livewire.accounts', [
            'groups' => $this->getGroups(),
        ]);
    }

    public function getGroups()
    {
        $query = Group::query()
            ->with("accounts.order")
            ->orderBy('id', 'desc')
            ->where(function (Builder $query) {
                $query->where("name", "like", "%{$this->search}%")
                    ->orWhereHas("accounts.order", function (Builder $query) {
                        $query->where("orders.order_id", "like", "%{$this->search}%");
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

        return $query->paginate();
    }

    public function removeGroup($id): void
    {
        Group::find($id)->delete();
    }

    public function addAccount(): void
    {
        $this->accounts_array[] = [
            'order_id' => '',
            'secure_phone' => '',
            'note' => '',
            'profile' => '',
        ];
    }

    public function removeAccount($index): void
    {
        $account = $this->accounts_array[$index];

        if ($account['id']) {
            Account::find($account['id'])->order()->delete();
        }

        array_splice($this->accounts_array, $index, 1);
    }

    public function save(): void
    {
        if ($this->group_id) {
            $this->update();
            return;
        }
        $this->store();
    }

    public function edit($group_id): void
    {
        $group = Group::find($group_id);
        $this->group_id = $group_id;
        $this->name = $group->name;
        $this->username = $group->username;
        $this->password = $group->password;
        $this->description = $group->description;
        $this->dispatch("trix_set_value", $this->description);

        $this->accounts_array = $group->accounts->map(function (Account $account) {
            return [
                'id' => $account->id,
                'order_id' => $account->order->order_id,
                'secure_phone' => $account->order->secure_phone,
                'note' => $account->order->note,
                'profile' => $account->profile,
            ];
        })->toArray();

    }

    private function update()
    {
        foreach ($this->accounts_array as $key => $account_array) {
            $count = $key + 1;
            if (isset($account_array['id'])) {

                $existsOrder = Order::leftJoin("accounts", "accounts.order_id", "orders.id")
                    ->where('orders.order_id', $account_array['order_id'])
                    ->where('accounts.id', '<>', $account_array['id'])
                    ->exists();
            } else {
                $existsOrder = Order::where('order_id', $account_array['order_id'])->exists();
            }
            if ($existsOrder && !empty($account_array['order_id'])) {
                return $this->addError('accounts_array', "الرقم التعريفي للحساب رقم $count موجود من قبل");
            }
        }

        $group = Group::find($this->group_id);
        $group->update([
            'name' => $this->name,
            'description' => $this->description,
            'username' => $this->username,
            'password' => $this->password,
        ]);

        foreach ($this->accounts_array as $account_array) {
            if (!isset($account_array['id'])) {
                app(AccountService::class)->store($group, $account_array);
                continue;
            }
            $account = Account::find($account_array['id']);

            $account->update([
                'profile' => $account_array['profile'],
            ]);
            $account->order()->update([
                'order_id' => $account_array['order_id'],
                'secure_phone' => $account_array['secure_phone'],
                'note' => $account_array['note'],
            ]);
        }
        session()->flash('message', 'تم الحفظ بنجاح');

        $this->clearData();
    }

    private function store()
    {
        if (empty($this->accounts_array)) {
            return $this->addError('accounts_array', "الحسابات مطلوبة . برجاء ادخال علي الاقل حساب واحد");
        }

        foreach ($this->accounts_array as $account_array) {
            $existsOrder = Order::where('order_id', $account_array['order_id'])->exists();
            if ($existsOrder && !empty($account_array['order_id'])) {
                return $this->addError('accounts_array', "الرقم التعريفي موجود من قبل");
            }
        }

        $this->validate([
            'username' => 'required',
            'password' => 'required',
        ], [
            'username.required' => 'اسم المستخدم مطلوب',
            'password.required' => 'كلمة المرور مطلوبة',
        ]);

        foreach ($this->accounts_array as $account_array) {
            $existsOrder = Order::where('order_id', $account_array['order_id'])->exists();
            if ($existsOrder && !empty($account_array['order_id'])) {
                return $this->addError('accounts_array', "الرقم التعريفي موجود من قبل");
            }
        }

        $group = Group::create([
            'name' => $this->name,
            'description' => $this->description,
            'username' => $this->username,
            'password' => $this->password,
        ]);
        foreach ($this->accounts_array as $accountArray) {
            app(AccountService::class)->store($group, $accountArray);
        }
        session()->flash('message', 'تم الحفظ بنجاح');

        $this->clearData();
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
        $this->dispatch("trix_clear_value");
    }
}
