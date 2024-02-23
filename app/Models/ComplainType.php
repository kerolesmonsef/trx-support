<?php

namespace App\Models;

use App\Traits\SLogActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @mixin IdeHelperComplainType
 */
class ComplainType extends Model
{
    use HasFactory, SLogActivity, SoftDeletes;

    protected $guarded = [];

    public function getTypeAr(): string
    {
        if ($this->type == "account"){
            return "بروفايل";
        }
        return "كوبون";
    }
}
