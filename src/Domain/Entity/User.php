<?php
declare(strict_types=1);
namespace App\Domain\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Domain\Repository\UserRepository;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ["email"], message: "Этот email уже зарегистрирован в системе.")]
final class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?string $name = null;

    #[ORM\Column(type: "string", length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private ?string $present = null;

    #[ORM\Column(nullable: true)]
    private ?int $recipient = null;

    #[ORM\Column(nullable: true)]
    private ?bool $actual = true;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getPresent(): ?string
    {
        return $this->present;
    }

    /**
     * @param string $present
     * @return $this
     */
    public function setPresent(string $present): self
    {
        $this->present = $present;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string|null $email
     * @return $this
     */
    public function setEmail(?string $email): self
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getRecipient(): ?int
    {
        return $this->recipient;
    }

    /**
     * @param int|null $recipient
     * @return $this
     */
    public function setRecipient(?int $recipient): self
    {
        $this->recipient = $recipient;
        return $this;
    }

    /**
     * @return bool|null
     */
    public function isActual(): ?bool
    {
        return $this->actual;
    }

    /**
     * @param bool|null $actual
     * @return $this
     */
    public function setActual(?bool $actual): self
    {
        $this->actual = $actual;
        return $this;
    }
}
