<?php
declare(strict_types=1);
namespace App\Api\v1\Actions;

use App\Api\v1\Request\FelicitateRequest;
use App\Api\v1\Responder\FelicitateResponder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/felicitate', name: 'felicitate', methods: 'POST')]
final class FelicitateAction extends AbstractController
{
    /**
     * @param FelicitateRequest $request
     * @param FelicitateResponder $responder
     * @return JsonResponse
     */
    public function __invoke(FelicitateRequest $request, FelicitateResponder $responder): JsonResponse
    {
        return $responder($request);
    }
}
