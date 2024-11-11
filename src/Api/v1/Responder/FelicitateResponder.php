<?php
declare(strict_types=1);
namespace App\Api\v1\Responder;

use App\Api\v1\Request\FelicitateRequest;
use App\Domain\Service\FelicitateService;
use App\Helpers\ResponseHelper;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Throwable;

final class FelicitateResponder extends AbstractType
{
    /**
     * @param FelicitateService $service
     */
    public function __construct(
        private readonly FelicitateService $service,
    ) {
    }

    /**
     * @param FelicitateRequest $request
     * @return JsonResponse
     */
    public function __invoke(FelicitateRequest $request): JsonResponse
    {
        try {
            if (true !== ($errors = $this->service->save($request->getData()))) {
                return ResponseHelper::error($errors);
            }
        } catch (Throwable $t) {
            return ResponseHelper::error($t->getMessage().'Сбой системы, попробуйте позже', 500);
        }

        return ResponseHelper::success('Подарок отправлен');
    }
}
