<?php
declare(strict_types=1);
namespace App\Web\Controller;

use App\Web\Responder\SenderResponder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class SenderController extends AbstractController
{

    #[Route('/sender', name: 'sender', methods: 'GET')]
    /**
     * @param SenderResponder $responder
     * @return Response
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function index(SenderResponder $responder): Response
    {
        return $responder();
    }
}
