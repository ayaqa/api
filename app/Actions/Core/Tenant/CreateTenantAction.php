<?php

namespace AyaQA\Actions\Core\Tenant;

use AyaQA\Concerns\Invocable;
use AyaQA\Contracts\CommandAction;
use AyaQA\Exceptions\Core\TenantException;
use AyaQA\Factories\Core\TenantFactory;
use AyaQA\Models\Core\Tenant;
use AyaQA\Settings\Core\CoreSettings;

class CreateTenantAction implements CommandAction
{
    use Invocable;

    public function __construct(
        private CoreSettings $coreSettings
    ){}

    public function handle(): Tenant
    {
        $factory = TenantFactory::make();
        if (false === $factory->isAllowedToCreate($this->coreSettings)) {
            throw TenantException::maxTenant($this->coreSettings->sessionsLimit);
        }

        return $factory->create();
    }
}
