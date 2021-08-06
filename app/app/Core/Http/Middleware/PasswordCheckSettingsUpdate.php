<?php

namespace AyaQA\Core\Http\Middleware;

use AyaQA\Core\Exceptions\UnauthorizedRequestException;
use AyaQA\Core\Service\AppSettingsService;
use Closure;

class PasswordCheckSettingsUpdate
{
    private AppSettingsService $appSettingsService;

    public function __construct(AppSettingsService $appSettingsService)
    {
        $this->appSettingsService = $appSettingsService;
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $isEqual = true;
        if ($this->appSettingsService->areSettingsProtected()) {
            $isEqual = $this->appSettingsService->isPasswordEqualTo($request->get('password', ''));
        }

        if (false === $isEqual) {
            throw UnauthorizedRequestException::withMessage(__('Provided password for updating settings is empty or invalid.'));
        }

        return $next($request);
    }
}
