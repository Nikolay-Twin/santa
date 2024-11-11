<?php
declare(strict_types=1);
namespace App\Web\Responder;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Forms;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment as TwigEnvironment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

final class SenderResponder extends AbstractType
{
    /**
     * @param TwigEnvironment $twig
     */
    public function __construct(
        private readonly TwigEnvironment $twig,
    ) {
    }

    /**
     * @return Response
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function __invoke(): Response
    {
        $formFactory = Forms::createFormFactory();
        $form = $formFactory->createBuilder()
            ->add('send', SubmitType::class,  [
                'label' => 'Начать',
            ])
            ->getForm();

        return new Response(
            $this->twig->render('sender.html.twig', [
                'form' => $form->createView()
            ])
        );
    }
}
