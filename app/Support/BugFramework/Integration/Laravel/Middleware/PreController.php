<?php

namespace AyaQA\Support\BugFramework\Integration\Laravel\Middleware;

use AyaQA\Support\BugFramework\AppStep;
use AyaQA\Support\BugFramework\Bug\BugManager;
use AyaQA\Support\BugFramework\Bug\Enum\ParamType;
use AyaQA\Support\BugFramework\Context\Event\AppStepUpdated;
use AyaQA\Support\BugFramework\Context\Event\SetContextValue;
use AyaQA\Support\BugFramework\Support\Controller\BuggableController;
use AyaQA\Support\BugFramework\Value\ValueType;
use Closure;
use Illuminate\Http\Request;

class PreController
{
    public function __construct(
        private BugManager $bugManager
    ){}

    /**
     * @param Request $request
     *
     * @param  Closure  $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next): mixed
    {
        $controllerClass = $request->route()->getController();
        if (is_subclass_of($controllerClass, BuggableController::class)) {
            // dispatch section for requested controller
            event(SetContextValue::from(ValueType::SECTION_ID, [$controllerClass::getSection()->getId()]));
        }

        // update app flow state
        event(AppStepUpdated::toStep(AppStep::PRE_CONTROLLER));

        $this->handleParamReplace($request);

        return $next($request);
    }

    protected function handleParamReplace(Request $request)
    {
        $postParams = $this->bugManager->getModifiedParameters(ParamType::POST);
        foreach ($postParams as $key => $value) {
            $request->request->set($key, $value);
        }
    }
}
