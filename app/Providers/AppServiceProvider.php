<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\Movement;
use App\Models\Supplier;
use App\Policies\Admin\UserPolicy;
use Illuminate\Support\Facades\Gate;
use App\Policies\Admin\ProductPolicy;
use App\Policies\Admin\CategoryPolicy;
use App\Policies\Admin\MovementPolicy;
use App\Policies\Admin\SupplierPolicy;
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
        Gate::policy(User::class, UserPolicy::class);
        Gate::policy(Supplier::class, SupplierPolicy::class);
        Gate::policy(Product::class, ProductPolicy::class);
        Gate::policy(Movement::class, MovementPolicy::class);
        Gate::policy(Category::class, CategoryPolicy::class);
    }
}
