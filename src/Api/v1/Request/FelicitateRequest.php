<?php
declare(strict_types=1);
namespace App\Api\v1\Request;

use Symfony\Component\Validator\Constraints as Assert;

class FelicitateRequest extends AbstractRequest
{

    #[Assert\NotBlank(
        message: 'Не выбран подарок',
    )]
    public string $present = '';

    #[Assert\NotBlank(
        message: 'Поле ФИО не заполнено',
    )]
    public string $name = '';

    #[Assert\NotBlank(
        message: 'Поле Email не заполнено',
    )]
    #[Assert\Email(
        message: "Переданный Email '{{ value }}' некорректен",
        mode: 'strict'
    )]
    public string $email = '';
}
