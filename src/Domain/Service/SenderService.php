<?php
declare(strict_types=1);
namespace App\Domain\Service;

use App\Domain\Entity\User;
use App\Domain\Service\Mail\QueueMailMessage;
use Psr\Container\ContainerExceptionInterface;
use \Psr\Container\NotFoundExceptionInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Exception\ExceptionInterface;
use DomainException;
use Throwable;

class SenderService
{
    private const BATCH_SIZE = 4;

    /**
     * @param EntityManagerInterface $entityManager
     * @param ContainerBagInterface $params
     * @param MessageBusInterface $bus
     * @param KernelInterface $appKernel
     */
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly ContainerBagInterface $params,
        private readonly MessageBusInterface $bus,
        private readonly KernelInterface $appKernel,
    ) {
    }

    /**
     * @return array|true
     */
    public function sendMail(): array|true
    {
        try {
            $cnt = $this->entityManager
                ->getRepository(User::class)
                ->count(['actual' => true]);

            if ($cnt < $this->params->get('min_party')) {
                return [['message' => 'Недостаточное количество участников']];
            } elseif ($cnt % 2  !== 0) {
                return [['message' => 'Нечетное число участников']];
            }

            // Если много пользователей, лучше пачками.
            $bath = ceil($cnt / self::BATCH_SIZE);
            while ($bath--) {
                $query = $this->createPair();
                $users = $query->getResult();
                shuffle($users);

                $donors = $recipients = [];
                do {
                    $recipients[] = $user = array_shift($users);
                    $donors[] = $recipient = array_shift($users);
                    $this->toQueue($user, $recipient);
                } while (current($users));

                foreach ($donors as $donor) {
                    if (false === next($recipients)) {
                        reset($recipients);
                    }
                    $this->toQueue($donor, current($recipients));
                }
                $this->entityManager->flush();
            }
        } catch (Throwable $t) {
            throw new DomainException($t->getMessage().'Сбой системы');
        }

        return true;
    }

    /**
     * @return Query
     */
    private function createPair(): Query
    {
        return $this->entityManager->getRepository(User::class)
            ->createQueryBuilder('user')
            ->where('user.actual = 1')
            ->orderBy('user.id', 'ASC')
            ->setMaxResults(self::BATCH_SIZE)
            ->getQuery();
    }

    /**
     * @param User $user
     * @param User $recipient
     * @return void
     */
    private function actualise(User $user, User $recipient): void
    {
        $user->setRecipient($recipient->getId());
        $user->setActual(false);
        $this->entityManager->persist($user);
    }

    /**
     * @param User $user
     * @param User $recipient
     * @return void
     * @throws ExceptionInterface
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    private function toQueue(User $user, User $recipient): void
    {
        $context = [
            'name' => $recipient->getName(),
            'recipientName' => $user->getName(),
            'recipientEmail' => $user->getEmail(),
        ];

        $embed = [[
            'path' => $this->appKernel->getProjectDir() .'/public/img/presents/'. $user->getPresent(),
            'id' => 'present',
            'mime' => 'image/jpeg',
        ]];

        $message = new QueueMailMessage(
            $this->params->get('admin_email'),
            $recipient->getEmail(),
            'Поздравление от Санты',
            'emails/felicitate.html.twig',
            $context,
            $embed
        );

        // В очередь, сукины дети! (с)
         $this->bus->dispatch($message);
         $this->actualise($user, $recipient);
    }
}
