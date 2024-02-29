<?php

namespace App\Providers;

use App\Helpers\Helper;
use Carbon\Carbon;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        Paginator::useBootstrapFive();

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Carbon::setLocale("ar");
//        DB::listen(function (QueryExecuted $query) {
//            info(Helper::getQueries($query));
//        });
    }


}
