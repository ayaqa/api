<?php

namespace AyaQA\Actions\Core\Tenant;

use AyaQA\Concerns\Invocable;
use AyaQA\Contracts\QueryAction;
use AyaQA\Models\Core\Tenant;
use AyaQA\Settings\Core\CoreSettings;
use Illuminate\Support\Collection;

class GetTenantsForAutoDeleteAction implements QueryAction
{
    use Invocable;

    public function __construct(
        private CoreSettings $settings
    ){}

    public function handle(): Collection
    {
        $tenants = collect();
        if ($this->settings->autoDeleteSession) {
            $tenants = Tenant::query()->forAutoDelete($this->settings->sessionDeleteAfter)->get();
        }

        return $tenants;
    }
}
