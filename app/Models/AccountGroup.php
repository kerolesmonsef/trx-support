<?php

namespace App\Models;

use App\Traits\SLogActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperAccountGroup
 */
class AccountGroup extends Model
{
    use HasFactory , SLogActivity;
    protected $table = 'account_groups';
    protected $guarded = [];
}
