<?php

namespace App\Trait;

use App\Helpers\AccountService;
use App\Models\Account;
use App\Models\Group;
use App\Models\Order;
use Illuminate\Database\Eloquent\Builder;

trait SaveAccountTrait
{
    public $accounts_array = [];


    public function addAccount(): void
    {
        $this->accounts_array[] = [
            'order_id' => '',
            'secure_phone' => '',
            'note' => '',
            'profile' => '',
            'warning_rank' => '',
            'warning_message' => '',
            'subscription_expire_at' => null,
        ];
    }

    public function removeAccount($index): void
    {
        $account = $this->accounts_array[$index];

        if ($account['id'] ?? null) {
            $account = Account::find($account['id']);
            $account?->delete();
            Order::find($account?->order_id)?->delete();
        }

        array_splice($this->accounts_array, $index, 1);
    }

    public function save(): void
    {
        if ($this->group_id) {
            $this->validateBeforeUpdate();
            return;
        }
        $this->validateBeforeStore();
    }

    public function acceptDuplicatedAccountId($data): void
    {
        $action = $data['action'];
        $this->$action();
    }


    public function edit($group_id): void
    {
        $group = Group::find($group_id);
        if (!$group) {
            return;
        }
        $this->group_id = $group_id;
        $this->name = $group->name;
        $this->username = $group->username;
        $this->password = $group->password;
        $this->description = $group->description;
        $this->dispatch('reloadClassicEditor', $this->description);


        $this->accounts_array = $group->accounts->load(["order" => function ($q) {
            /** @var Builder $q */
            $q->with("notes");
            $q->with("complains");
        }])->map(function (Account $account) {
            return [
                'id' => $account->id,
                'order_id' => $account->order->order_id,
                'secure_phone' => $account->order->secure_phone,
                'note' => $account->order->note,
                'profile' => $account->profile,
                'warning_rank' => $account->order->warning_rank,
                'warning_message' => $account->order->warning_message,
                'account_object' => $account,
                'subscription_expire_at' => $account->subscription_expire_at,
            ];
        })->toArray();

    }

    public function validateBeforeUpdate()
    {
        if (empty($this->accounts_array)) {
            return $this->addError('accounts_array', "البروفايلات مطلوبة . برجاء ادخال علي الاقل بروفايل واحد");
        }

        $this->validate([
            'username' => 'required',
            'password' => 'required',
        ], [
            'username.required' => 'اسم المستخدم مطلوب',
            'password.required' => 'كلمة المرور مطلوبة',
        ]);

        $existsUserName = Group::where("username", $this->username)->where("id", "<>", $this->group_id)->exists();
        $existsOrderIds = [];

        foreach ($this->accounts_array as $account_array) {
            $order_id = $account_array['order_id'];
            if (!$order_id) {
                return $this->addError('accounts_array', "رقم الطلب مطلوب");
            }

            if (isset($account_array['id'])) {
                $existsOrder = Order::leftJoin("accounts", "accounts.order_id", "orders.id")
                    ->where('orders.order_id', $order_id)
                    ->where('accounts.id', '<>', $account_array['id'])
                    ->exists();
            } else {
                $existsOrder = Order::where('order_id', $order_id)->exists();
            }
            if ($existsOrder) {
                $existsOrderIds[] = $order_id;
            }
        }

        if (!empty($existsOrderIds) || $existsUserName) {
            $this->dispatch("openModal", component: 'duplicated-account-id-modal', arguments: [
                'orderIds' => $existsOrderIds,
                'action' => "update",
                'username' => $existsUserName ? $this->username : null,
            ]);
            return;
        }
        $this->update();
    }

    protected function update(): void
    {
        $group = Group::find($this->group_id);
        $group->update([
            'name' => $this->name,
            'description' => $this->description,
            'username' => $this->username,
            'password' => $this->password,
            'last_updated_user_id' => auth()->id(),
        ]);

        foreach ($this->accounts_array as $account_array) {
            if (!isset($account_array['id'])) {
                app(AccountService::class)->store($group, $account_array);
                continue;
            }
            $account = Account::find($account_array['id']);

            $account->update([
                'profile' => $account_array['profile'],
                'subscription_expire_at' => $account_array['subscription_expire_at'] ?: null,
            ]);
            $account->order()->update([
                'order_id' => $account_array['order_id'],
                'secure_phone' => $account_array['secure_phone'],
                'note' => $account_array['note'],
                'warning_rank' => $account_array['warning_rank'] ?: null,
                'warning_message' => $account_array['warning_message'],
            ]);
        }
        session()->flash('message', 'تم الحفظ بنجاح');

        $this->clearData();
    }

    protected function validateBeforeStore()
    {
        if (empty($this->accounts_array)) {
            return $this->addError('accounts_array', "البروفايلات مطلوبة . برجاء ادخال علي الاقل بروفايل واحد");
        }

        $this->validate([
            'username' => 'required',
            'password' => 'required',
        ], [
            'username.required' => 'اسم المستخدم مطلوب',
            'password.required' => 'كلمة المرور مطلوبة',
        ]);
        $existsUserName = Group::where("username", $this->username)->exists();
        $existsOrderIds = [];
        foreach ($this->accounts_array as $account_array) {
            $order_id = $account_array['order_id'];
            if (!$order_id) {
                return $this->addError('accounts_array', "رقم الطلب مطلوب");
            }
            $existsOrder = Order::where('order_id', $order_id)->exists();
            if ($existsOrder) {
                $existsOrderIds[] = $order_id;
            }
        }


        if (!empty($existsOrderIds) || $existsUserName) {
            $this->dispatch("openModal", component: 'duplicated-account-id-modal', arguments: [
                'orderIds' => $existsOrderIds,
                'action' => "store",
                'username' => $existsUserName ? $this->username : null,
            ]);
            return;
        }
        $this->store();
    }

    protected function store(): void
    {
        $group = Group::create([
            'name' => $this->name,
            'description' => $this->description,
            'username' => $this->username,
            'password' => $this->password,
            'creator_user_id' => auth()->id(),
        ]);
        foreach ($this->accounts_array as $accountArray) {
            app(AccountService::class)->store($group, $accountArray);
        }
        session()->flash('message', 'تم الحفظ بنجاح');

        $this->clearData();
    }

}
