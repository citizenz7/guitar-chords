<?php

namespace App\Entity;

use App\Repository\SettingRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SettingRepository::class)]
class Setting
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $siteName = null;

    #[ORM\Column(length: 255)]
    private ?string $siteEmail = null;

    #[ORM\Column(length: 255)]
    private ?string $siteUrl = null;

    #[ORM\Column(length: 255)]
    private ?string $siteUrlfull = null;

    #[ORM\Column(length: 255)]
    private ?string $siteAddress = null;

    #[ORM\Column(length: 255)]
    private ?string $siteCp = null;

    #[ORM\Column(length: 255)]
    private ?string $siteCity = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $siteTelephone = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $siteDescription = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $siteLogo = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSiteName(): ?string
    {
        return $this->siteName;
    }

    public function setSiteName(string $siteName): static
    {
        $this->siteName = $siteName;

        return $this;
    }

    public function getSiteEmail(): ?string
    {
        return $this->siteEmail;
    }

    public function setSiteEmail(string $siteEmail): static
    {
        $this->siteEmail = $siteEmail;

        return $this;
    }

    public function getSiteUrl(): ?string
    {
        return $this->siteUrl;
    }

    public function setSiteUrl(string $siteUrl): static
    {
        $this->siteUrl = $siteUrl;

        return $this;
    }

    public function getSiteUrlfull(): ?string
    {
        return $this->siteUrlfull;
    }

    public function setSiteUrlfull(string $siteUrlfull): static
    {
        $this->siteUrlfull = $siteUrlfull;

        return $this;
    }

    public function getSiteAddress(): ?string
    {
        return $this->siteAddress;
    }

    public function setSiteAddress(string $siteAddress): static
    {
        $this->siteAddress = $siteAddress;

        return $this;
    }

    public function getSiteCp(): ?string
    {
        return $this->siteCp;
    }

    public function setSiteCp(string $siteCp): static
    {
        $this->siteCp = $siteCp;

        return $this;
    }

    public function getSiteCity(): ?string
    {
        return $this->siteCity;
    }

    public function setSiteCity(string $siteCity): static
    {
        $this->siteCity = $siteCity;

        return $this;
    }

    public function getSiteTelephone(): ?string
    {
        return $this->siteTelephone;
    }

    public function setSiteTelephone(?string $siteTelephone): static
    {
        $this->siteTelephone = $siteTelephone;

        return $this;
    }

    public function getSiteDescription(): ?string
    {
        return $this->siteDescription;
    }

    public function setSiteDescription(?string $siteDescription): static
    {
        $this->siteDescription = $siteDescription;

        return $this;
    }

    public function getSiteLogo(): ?string
    {
        return $this->siteLogo;
    }

    public function setSiteLogo(?string $siteLogo): static
    {
        $this->siteLogo = $siteLogo;

        return $this;
    }
}
