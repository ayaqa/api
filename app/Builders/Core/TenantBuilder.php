<?php

namespace AyaQA\Builders\Core;

use AyaQA\Enum\Core\TenantState;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Date;

class TenantBuilder extends Builder
{
    public function dbExists(string $dbName): bool
    {
        return $this->sessions(false)->where('database', $dbName)->exists();
    }

    public function sessionExists(string $sessionId): bool
    {
        return $this->sessions(false)->where('session', $sessionId)->exists();
    }

    /**
     * @param string $identifier
     *
     * @return self
     */
    public function byIdentifier(string $identifier): self
    {
        return $this
            ->where('state', '!=', TenantState::DELETING)
            ->where(function(Builder $query) use ($identifier) {
                $query
                    ->where('id', '=', $identifier)
                    ->orWhere('session', '=', $identifier);
            });
    }

    /**
     * @param bool $withDeleted
     *
     * @return self
     */
    public function sessions(bool $withDeleted = false): self
    {
        return $this->when($withDeleted, function(Builder $q) {
            $q->orWhereNotNull('deleted_at');
        }, function(Builder $q) {
            $q->where('state', '!=', TenantState::DELETING);
        });
    }

    /**
     * @param int $timeSinceLastRequestInSeconds
     *
     * @return self
     */
    public function forAutoDelete(int $timeSinceLastRequestInSeconds): self
    {
        $dateTime = Date::now('UTC')->subSeconds($timeSinceLastRequestInSeconds)->toDateTimeString();

        return $this->sessions(false)
            ->where('deletable', '=', 1)
            ->where(function (Builder $query) use ($dateTime) {
                $query->where('created_at', '<=', $dateTime);
                $query->whereNull('requested_at');
            })
            ->orWhere('requested_at', '<=', $dateTime);
    }
}
