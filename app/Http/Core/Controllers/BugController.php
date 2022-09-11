<?php

namespace AyaQA\Http\Core\Controllers;

use AyaQA\Concerns\ResponseTrait;
use AyaQA\Support\BugFramework\Bug\Service\UIBugsFormatter;
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

        // @TODO move to action
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
        // @TODO move to action

        $postData = $request->post();

        $bugStorageService->storeBugs($postData);

        return $this->respond($postData);
    }

    public function getUIBugs(BugStorageService $bugStorageService, UIBugsFormatter $bugsFormatter): JsonResponse
    {
        // @TODO move to action
        return $this->respond([
            'areHashed'   => false,
            'bugs'        => base64_encode(json_encode($bugsFormatter->toArray($bugStorageService->getUIBugs())))
        ]);
    }
}
