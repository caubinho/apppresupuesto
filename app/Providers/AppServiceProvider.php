<?php

namespace App\Providers;

use App\Models\Budget;
use App\Models\BudgetItem;
use App\Observers\BudgetItemObserver;
use App\Observers\BudgetObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Budget::observe(BudgetObserver::class);
        BudgetItem::observe(BudgetItemObserver::class);
    }
}
