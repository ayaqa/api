<?php

namespace AyaQA\Http\Core\Controllers;

use AyaQA\Concerns\ResponseTrait;
use AyaQA\Support\Bug\BugManager;
use AyaQA\Support\Bug\Manifest\Enum\ApplicableTo;
use AyaQA\Support\Bug\Manifest\ManifestManager;
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

    public function getBugs(Request $request, BugManager $bugManager): JsonResponse
    {
        return $this->respond($bugManager->fetchBugs()->getBugs());
    }

    public function storeBugs(Request $request, BugManager $bugManager): JsonResponse
    {
        $postData = $request->post();

        $bugManager->replaceBugs($postData);

        return $this->respond($postData);
    }
}
