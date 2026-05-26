<?php

namespace App\Providers;

use App\Repositories\Contracts\DealRepositoryInterface;
use App\Repositories\Contracts\DealTypeRepositoryInterface;
use App\Repositories\Contracts\DeliverableRepositoryInterface;
use App\Repositories\Contracts\InternalTeamRepositoryInterface;
use Illuminate\Support\ServiceProvider;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\DealRepository;
use App\Repositories\Contracts\SponserRepositoryInterface;
use App\Repositories\Contracts\TicketRepositoryInterface;
use App\Repositories\DeliverableRepository;
use App\Repositories\Eloquent\DealTypeRepository;
use App\Repositories\Eloquent\SponserRepository;
use App\Repositories\Eloquent\UserRepository;
use App\Repositories\InternalTeamRepository;
use App\Repositories\Invoice\InvoiceRepository;
use App\Repositories\Invoice\InvoiceRepositoryInterface;
use App\Repositories\TicketRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(DealRepositoryInterface::class,DealRepository::class);
        $this->app->bind(SponserRepositoryInterface::class, SponserRepository::class);
        $this->app->bind(DealTypeRepositoryInterface::class, DealTypeRepository::class);
        $this->app->bind(DeliverableRepositoryInterface::class, DeliverableRepository::class);
        $this->app->bind(InternalTeamRepositoryInterface::class,InternalTeamRepository::class);
        $this->app->bind(TicketRepositoryInterface::class,TicketRepository::class);

        $this->app->bind(InvoiceRepositoryInterface::class,InvoiceRepository::class);
    }
} 


