<?php
declare(strict_types=1);
namespace App\Web\Responder;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Forms;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment as TwigEnvironment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

final class HomepageResponder extends AbstractType
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
            ->add('name', TextType::class,  [
                'label' => 'ФИО',
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email',
            ])
            ->add('presents', ChoiceType::class, [
                'choices' => [
                    '1' => '1.jpg',
                    '2' => '2.jpeg',
                    '3' => '3.jpeg',
                ],
                'expanded' => true,
                'multiple' => false,
            ])
            ->add('send', SubmitType::class,  [
                'label' => 'Отправить подарок',
            ])
            ->getForm();

        return new Response(
            $this->twig->render('home.html.twig', [
                'form' => $form->createView()
            ])
        );
    }
}
