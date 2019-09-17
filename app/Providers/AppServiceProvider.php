<?php

namespace App\Providers;

use App\Models\Building;
use App\Models\Quarter;
use App\Models\Post;
use App\Models\Product;
use App\Models\PropertyManager;
use App\Models\RealEstate;
use App\Models\ServiceRequest;
use App\Models\Template;
use App\Models\Conversation;
use App\Models\Tenant;
use App\Models\RentContract;
use App\Models\Unit;
use App\Models\User;
use App\Notifications\NewTenantPost;
use App\Notifications\NewTenantRequest;
use App\Notifications\PostPublished;
use App\Notifications\ProductPublished;
use App\Notifications\StatusChangedRequest;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use OwenIt\Auditing\Models\Audit;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
	    Schema::defaultStringLength(191);

        Audit::creating(function (Audit $model) {
            if (empty($model->old_values) && empty($model->new_values)) {
                return false;
            }
        });

	    Relation::morphMap([
            'unit' => Unit::class,
            'user' => User::class,
            'post' => Post::class,
            'tenant' => Tenant::class,
            'product' => Product::class,
            'quarter' => Quarter::class,
            'building' => Building::class,
            'templates' => Template::class,
            'request' => ServiceRequest::class,
            'real_estate' => RealEstate::class,
            'manager' => PropertyManager::class,
            'translation' => \App\Models\Translation::class,
            'provider' => \App\Models\ServiceProvider::class,
            'rent_contract' => RentContract::class,
            'conversation' => Conversation::class,

            'post_published' => PostPublished::class,
            'new_tenant_post' => NewTenantPost::class,
            'product_published' => ProductPublished::class,
            'new_tenant_request' => NewTenantRequest::class,
            'status_change_request' => StatusChangedRequest::class,
        ]);

        if (!Collection::hasMacro('paginate')) {
            Collection::macro('paginate', function ($perPage = 15, $page = null, $options = []) {
                $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
                $paginator = new LengthAwarePaginator($this->forPage($page, $perPage), $this->count(), $perPage, $page, $options);
                return $paginator->withPath(\Request::url());
            });
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            \Cog\Contracts\Love\Like\Models\Like::class,
            \App\Models\Like::class
        );
    }
}
