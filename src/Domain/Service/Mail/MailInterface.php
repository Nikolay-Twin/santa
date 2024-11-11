<?php
declare(strict_types=1);
namespace App\Domain\Service\Mail;

interface MailInterface
{
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
    ): bool;
}
