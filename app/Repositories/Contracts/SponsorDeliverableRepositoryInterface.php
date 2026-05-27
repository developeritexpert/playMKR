<?php

namespace App\Repositories\Contracts;

interface SponsorDeliverableRepositoryInterface
{
    public function getDeliverablesWithStats(int $sponsorId, array $filters);

    public function getDeliverableById(int $sponsorId, int $deliverableId);
}