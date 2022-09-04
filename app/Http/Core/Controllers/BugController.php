<?php

namespace AyaQA\Http\Core\Controllers;

use AyaQA\Concerns\ResponseTrait;
use AyaQA\Support\BugFramework\Integration\Laravel\Storage\BugStorageService;
use AyaQA\Support\BugFramework\Manifest\ManifestManager;
use AyaQA\Support\BugFramework\Support\ApplicableTo;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BugController
{
    use ResponseTrait;

    public function manifest(ManifestManager $manifestManager): JsonResponse
    {
        // @TODO register available targets from config
        $manifestManager->boot();

        return $this->respond([
            'targets'       => $manifestManager->presentTargets(),
            'bugs'          => $manifestManager->presentBugs(),
            'conditions'    => $manifestManager->presentConditions(),
            'applicable'    => ApplicableTo::present()
        ]);
    }

    public function getBugs(BugStorageService $bugStorageService): JsonResponse
    {
        return $this->respond($bugStorageService->getBugs()->toArray());
    }

    public function storeBugs(Request $request, BugStorageService $bugStorageService): JsonResponse
    {
        $postData = $request->post();

        $bugStorageService->storeBugs($postData);

        return $this->respond($postData);
    }
}
