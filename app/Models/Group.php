<?php

namespace App\Models;

use App\Traits\SLogActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperGroup
 */
class Group extends Model
{
    use HasFactory , SLogActivity;

    protected $table = 'groups_a';

    protected $guarded = [];

    public function accounts()
    {
        return $this->hasMany(Account::class);
    }
}
