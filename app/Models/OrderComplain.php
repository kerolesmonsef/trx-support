<?php

namespace App\Models;

use App\Traits\SLogActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @mixin IdeHelperOrderComplain
 */
class OrderComplain extends Model
{
    use HasFactory, SoftDeletes, SLogActivity;

    protected $guarded = [];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function type()
    {
        return $this->belongsTo(ComplainType::class, 'complain_type_id')->withTrashed();
    }

    public function lastUpdatedUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'last_updated_user_id');
    }

    public function isPending(): bool
    {
        return $this->status == 'pending';
    }

    public function isSolved(): bool
    {
        return $this->status == 'solved';
    }

    public function notSolved(): bool
    {
        return $this->status == 'not_solved';
    }
}
