<?php
declare(strict_types=1);
namespace App\Domain\Service\Mail;

use Exception;

final class Other implements MailInterface
{
    /**
     * Если потребуется использовать внешнюю интеграцию с сервисом рассылок
     */
    public function __construct()
    {
        throw new Exception('Адаптер '. __CLASS__ .' не реализован');
    }

    /**
     * @param string $from
     * @param string $to
     * @param string $subject
     * @param string|null $template
     * @param array|null $context
     * @param array|null $embed
     * @return bool
     */
    public function send(
        string $from,
        string $to,
        string $subject,
        ?string $template,
        ?array $context = [],
        ?array $embed = []
    ): bool {return false;
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return [];
    }

    /**
     * @return bool
     */
    public function success(): bool
    {
        return false;
    }
}
