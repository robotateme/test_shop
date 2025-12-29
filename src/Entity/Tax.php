<?php

namespace App\Entity;

use App\Enum\CouponTypesEnum;
use App\Repository\TaxRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TaxRepository::class)]
class Tax
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 32)]
    private ?string $code = null;

    #[ORM\Column(enumType: CouponTypesEnum::class)]
    private ?CouponTypesEnum $type = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): static
    {
        $this->code = $code;

        return $this;
    }

    public function getType(): ?CouponTypesEnum
    {
        return $this->type;
    }

    public function setType(?CouponTypesEnum $type): void
    {
        $this->type = $type;
    }
}
