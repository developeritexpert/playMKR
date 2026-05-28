<?php

namespace App\Providers;

use App\Repositories\Contracts\DealRepositoryInterface;
use App\Repositories\Contracts\DealTypeRepositoryInterface;
use App\Repositories\Contracts\DeliverableRepositoryInterface;
use App\Repositories\Contracts\InternalTeamRepositoryInterface;
use Illuminate\Support\ServiceProvider;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\DealRepository;
use App\Repositories\Contracts\SponsorRepositoryInterface;
use App\Repositories\Contracts\TicketRepositoryInterface;
use App\Repositories\DeliverableRepository;
use App\Repositories\Eloquent\DealTypeRepository;
use App\Repositories\Eloquent\SponsorRepository;
use App\Repositories\Eloquent\UserRepository;
use App\Repositories\InternalTeamRepository;
use App\Repositories\Invoice\InvoiceRepository;
use App\Repositories\Invoice\InvoiceRepositoryInterface;
use App\Repositories\TicketRepository;
use App\Repositories\Contracts\SponsorDeliverableRepositoryInterface;
use App\Repositories\Sponsor\SponsorDeliverableRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(DealRepositoryInterface::class,DealRepository::class);
        $this->app->bind(SponsorRepositoryInterface::class, SponsorRepository::class);
        $this->app->bind(DealTypeRepositoryInterface::class, DealTypeRepository::class);
        $this->app->bind(DeliverableRepositoryInterface::class, DeliverableRepository::class);
        $this->app->bind(InternalTeamRepositoryInterface::class,InternalTeamRepository::class);
        $this->app->bind(TicketRepositoryInterface::class,TicketRepository::class);

        $this->app->bind(InvoiceRepositoryInterface::class,InvoiceRepository::class);

        // Sponsor
        $this->app->bind(SponsorDeliverableRepositoryInterface::class, SponsorDeliverableRepository::class);
    }
} 


