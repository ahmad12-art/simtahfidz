<?php

namespace App\Providers;

use App\Models\Murajaah;
use App\Models\Santri;
use App\Models\Setoran;
use App\Models\TargetHafalan;
use App\Policies\SantriPolicy;
use App\Policies\SetoranPolicy;
use App\Policies\TargetHafalanPolicy;
use Illuminate\Support\Facades\Gate;
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
        Gate::policy(Santri::class, SantriPolicy::class);
        Gate::policy(TargetHafalan::class, TargetHafalanPolicy::class);
        Gate::policy(Setoran::class, SetoranPolicy::class);
    }
}
