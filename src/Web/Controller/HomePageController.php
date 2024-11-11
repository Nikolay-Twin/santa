<?php
declare(strict_types=1);
namespace App\Web\Controller;

use App\Web\Responder\HomepageResponder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class HomePageController extends AbstractController
{

    #[Route('/', name: 'homepage', methods: 'GET')]
    /**
     * @param HomepageResponder $responder
     * @return Response
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function index(HomepageResponder $responder): Response
    {
        return $responder();
    }
}
