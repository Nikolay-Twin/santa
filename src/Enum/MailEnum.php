<?php
declare(strict_types=1);
namespace App\Enum;

enum MailEnum: string
{
    use EnumTrait;

    case DEFAULT = 'SymfonyMailer';
    case OTHER = 'Other';
}
