<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait SearchableAndFilterable
{
    public function scopeFilterAndSearch(Builder $query, array $filters = [], array $searchableColumns = [])
    {
        if (!empty($filters['search']) && !empty($searchableColumns)) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search, $searchableColumns) {
                foreach ($searchableColumns as $column) {
                    if (str_contains($column, '.')) {
                        [$relation, $relCol] = explode('.', $column);
                        $q->orWhereHas($relation, fn($rq) => $rq->where($relCol, 'like', "%{$search}%"));
                    } else {
                        $q->orWhere($column, 'like', "%{$search}%");
                    }
                }
            });
        }

          if (!empty($filters['status'])) {
            $statusColumn = in_array('payment_status', $this->getFillable()) ? 'payment_status' : 'status';
            
            if (in_array($statusColumn, $this->getFillable())) {
                $query->where($statusColumn, $filters['status']);
            }
        }

        // Date Range Filter (From Date / To Date)
        if (!empty($filters['from_date']) && !empty($filters['to_date'])) {
            $query->whereBetween('created_at', [$filters['from_date'] . ' 00:00:00', $filters['to_date'] . ' 23:59:59']);
        } elseif (!empty($filters['from_date'])) {
            $query->where('created_at', '>=', $filters['from_date'] . ' 00:00:00');
        } elseif (!empty($filters['to_date'])) {
            $query->where('created_at', '<=', $filters['to_date'] . ' 23:59:59');
        }

        // Sort By Date
        if (!empty($filters['date_sort'])) {
            $query->orderBy('created_at', strtolower($filters['date_sort']) === 'asc' ? 'asc' : 'desc');
        } else {
            $query->orderBy('created_at', 'desc'); 
        }

        return $query;
    }
}