<?php

namespace OpenLibrary\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use OpenLibrary\Models\Book;
use OpenLibrary\Models\BookRental;
use OpenLibrary\Models\User;
use OpenLibrary\Models\UserProfile;
use OpenLibrary\Policies\BookPolicy;
use OpenLibrary\Policies\BookRentalPolicy;
use OpenLibrary\Policies\UserPolicy;
use OpenLibrary\Policies\UserProfilePolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        User::class => UserPolicy::class,
        UserProfile::class => UserProfilePolicy::class,
        Book::class => BookPolicy::class,
        BookRental::class => BookRentalPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
