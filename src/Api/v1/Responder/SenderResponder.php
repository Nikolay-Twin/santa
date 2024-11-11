<?php
declare(strict_types=1);
namespace App\Api\v1\Responder;

use App\Domain\Service\SenderService;
use App\Helpers\ResponseHelper;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Throwable;

final class SenderResponder extends AbstractType
{
    /**
     * @param SenderService $service
     */
    public function __construct(
        private readonly SenderService $service
    ) {
    }

    /**
     * @return JsonResponse
     */
    public function __invoke(): JsonResponse
    {
        try {
            if (true !== ($errors = $this->service->sendMail())) {
                return ResponseHelper::error($errors);
            }
        } catch (Throwable $t) {
            return ResponseHelper::error(
                $t->getMessage() .'Сбой системы, попробуйте позже',
                500
            );
        }

        return ResponseHelper::success('Рассылка отправлена в очередь');
    }
}
