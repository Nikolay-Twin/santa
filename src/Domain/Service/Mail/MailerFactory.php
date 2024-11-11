<?php
declare(strict_types=1);
namespace App\Domain\Service\Mail;

use App\Enum\MailEnum;
use Symfony\Component\Mailer\MailerInterface;
use DomainException;

class MailerFactory
{
    /**
     * @param MailerInterface $mailer
     */
    public function __construct(
        private MailerInterface $mailer
    ) {
    }

    /**
     * @param string $className
     * @return false|MailInterface
     */
    public function make(string $className): false|MailInterface
    {
        if (in_array($className, MailEnum::getValues())) {
            $class = $this->findClass($className);
            if (!MailInterface::class instanceof $class) {
                $instance = new $class();
                if (method_exists($instance, 'setMailer')) {
                    $instance->setMailer($this->mailer);
                }
                return $instance;
            } else {
                throw new DomainException(
                    sprintf('Class %s does not implement %s', $class, MailInterface::class)
                );
            }
        }
        throw new DomainException(
            sprintf('Mailer %s not registered in %s', $className, MailEnum::class)
        );
    }

    /**
     * @param string $className
     * @return string
     */
    protected function findClass(string $className): string
    {
        $className = __NAMESPACE__ .'\\'. ucfirst($className);
        return match (true) {
            class_exists($className) => $className,
            default => throw new DomainException(
                sprintf('Class %s not found in %s', $className, dirname(__DIR__))
            )
        };
    }
}
