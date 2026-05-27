<?php

namespace App\Repositories\Sponsor;

use App\Models\Deliverable;
use App\Repositories\Contracts\SponsorDeliverableRepositoryInterface;
use Carbon\Carbon;

class SponsorDeliverableRepository implements SponsorDeliverableRepositoryInterface
{
    public function getDeliverablesWithStats(int $sponsorId, array $filters)
    {
        // Base Query scoped to the sponsor's deals
        $query = Deliverable::with(['deal'])->whereHas('deal', function ($q) use ($sponsorId) {
            $q->where('sponsor_id', $sponsorId);
        });

        // 1. Search Filter (by Deliverable Title, Deal Title, or Deal ID)
        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhereHas('deal', function ($dq) use ($search) {
                      $dq->where('deal_title', 'like', "%{$search}%")
                         ->orWhere('id', 'like', "%{$search}%");
                  });
            });
        }

        // 2. Time Filter
        if (!empty($filters['time'])) {
            $time = $filters['time'];
            $now = Carbon::now();

            if ($time === 'today') {
                $query->whereDate('created_at', $now->toDateString());
            } elseif ($time === 'this_week') {
                $query->whereBetween('created_at', [$now->startOfWeek()->toDateString(), $now->endOfWeek()->toDateString()]);
            } elseif ($time === 'this_month') {
                $query->whereYear('created_at', $now->year)->whereMonth('created_at', $now->month);
            } elseif (preg_match('/^last_(\d+)_days$/', $time, $matches)) {
                $days = (int) $matches[1];
                $query->whereDate('created_at', '>=', $now->subDays($days)->toDateString());
            }
        }

        // --- CALCULATE STATS USING DEAL'S STATUS ---
        $statsQuery = clone $query;
        $total = $statsQuery->count();
        
        $completed = (clone $statsQuery)->whereHas('deal', function($q) {
            $q->where('status', 'Completed');
        })->count();
        
        $inProgress = (clone $statsQuery)->whereHas('deal', function($q) {
            $q->where('status', 'Active'); 
        })->count();
        
        $pending = (clone $statsQuery)->whereHas('deal', function($q) {
            $q->where('status', 'Pending');
        })->count();
        
        $progressPercentage = $total > 0 ? round(($completed / $total) * 100) : 0;

        // 3. Status Filter (Applied to the table pagination only)
        if (!empty($filters['status'])) {
            $status = $filters['status'];
            $query->whereHas('deal', function($q) use ($status) {
                $q->where('status', $status);
            });
        }

        // 4. Pagination
        $perPage = $filters['per_page'] ?? 10;
        $paginatedData = $query->latest()->paginate($perPage);

        return [
            'stats' => [
                'total' => $total,
                'completed' => $completed,
                'in_progress' => $inProgress,
                'pending' => $pending,
                'progress_percentage' => $progressPercentage
            ],
            'deliverables' => $paginatedData
        ];
    }

    public function getDeliverableById(int $sponsorId, int $deliverableId)
    {
        return Deliverable::with(['deal', 'deliverType'])
            ->where('id', $deliverableId)
            ->whereHas('deal', function ($q) use ($sponsorId) {
                $q->where('sponsor_id', $sponsorId);
            })
            ->first();
    }
}