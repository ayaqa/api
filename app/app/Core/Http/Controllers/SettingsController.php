<?php

namespace AyaQA\Core\Http\Controllers;

use AyaQA\Core\Exceptions\Base\APIException;
use AyaQA\Core\Http\Request\AppSettingsRequest;
use AyaQA\Core\Http\ResponseWrapper;
use AyaQA\Core\Service\AppSettingsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;

class SettingsController extends BaseController
{
    /**
     * @param AppSettingsService $appSettingsService
     *
     * @return JsonResponse
     */
    public function settings(AppSettingsService $appSettingsService)
    {
        return new JsonResponse(ResponseWrapper::success($appSettingsService->toArray()));
    }

    public function update(AppSettingsRequest $settingsRequest, AppSettingsService $appSettingsService)
    {
        $isSaved = $appSettingsService->updateFromRequest($settingsRequest);

        return response()->json(ResponseWrapper::generic($isSaved, $appSettingsService->toArray()));
    }
}
