<?php
declare(strict_types=1);
namespace App\Domain\Service;

use App\Domain\Entity\User;
use Symfony\Component\Validator\ConstraintViolationList;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use DomainException;
use Throwable;

class FelicitateService
{
    /**
     * @param EntityManagerInterface $entityManager
     * @param ValidatorInterface $validator
     */
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly ValidatorInterface $validator
    ) {
    }


    /**
     * @param object $data
     * @return ConstraintViolationList|true
     */
    public function save(object $data): ConstraintViolationList|true
    {
        try {
            $user = new User();
            $user->setName($data->name);
            $user->setEmail($data->email);
            $user->setPresent($data->present);

            $errors = $this->validator->validate($user);
            if (count($errors)) {
                return $errors;
            }

            $this->entityManager->persist($user);
            $this->entityManager->flush();
        } catch (Throwable $t) {
            throw new DomainException($t->getMessage());
        }

        return true;
    }
}
