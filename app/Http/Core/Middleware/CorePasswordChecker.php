<?php

namespace AyaQA\Http\Core\Middleware;

use AyaQA\Dtos\Core\SessionDto;
use AyaQA\Exceptions\Core\TenantException;
use AyaQA\Settings\Core\CoreSettings;

class CorePasswordChecker
{
    public function __construct(
        private CoreSettings $coreSettings,
        private SessionDto $sessionDto,
    ){}

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     *
     * @return mixed
     */
    public function handle($request, \Closure $next, $isRequired = false)
    {
        $password = $request->input('password', false);

        $hasValidPassword = false;
        if (false !== $password && $password === $this->coreSettings->password) {
            $hasValidPassword = true;
        }


        if ($isRequired && false === $hasValidPassword) {
            throw TenantException::noPermission();
        }

        $this->sessionDto->setVerifiedPassword($hasValidPassword);

        return $next($request);
    }
}
