<?php
declare(strict_types=1);
namespace App\Api\v1\Actions;

use App\Api\v1\Responder\SenderResponder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/begin', name: 'begin', methods: 'POST')]
final class SenderAction extends AbstractController
{
    /**
     * @param Request $request
     * @param SenderResponder $responder
     * @return JsonResponse
     */
    public function __invoke(Request $request, SenderResponder $responder): JsonResponse
    {
        return $responder();
    }
}
