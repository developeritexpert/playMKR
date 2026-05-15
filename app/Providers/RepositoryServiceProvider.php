<?php

namespace App\Providers;

use App\Repositories\Contracts\DealRepositoryInterface;
use App\Repositories\Contracts\SponsorRepositoryInterface;
use Illuminate\Support\ServiceProvider;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\DealRepository;
use App\Repositories\Contracts\SponserRepositoryInterface;
use App\Repositories\Eloquent\SponserRepository;
use App\Repositories\Eloquent\UserRepository;
use App\Repositories\SponsorRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(SponsorRepositoryInterface::class,SponsorRepository::class);
        $this->app->bind(DealRepositoryInterface::class,DealRepository::class);
        $this->app->bind(SponserRepositoryInterface::class, SponserRepository::class);
    }
}


