<?php

namespace App\Entity;

use App\Repository\AvatarRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AvatarRepository::class)]
class Avatar
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $width = null;

    #[ORM\Column]
    private ?int $height = null;

    #[ORM\Column(length: 255)]
    private ?string $style = null;

    #[ORM\Column(length: 255)]
    private ?string $background = null;

    #[ORM\Column(length: 255)]
    private ?string $svgBackground = null;

    #[ORM\Column(length: 255)]
    private ?string $skin = null;

    #[ORM\Column(length: 255)]
    private ?string $top = null;

    #[ORM\Column(length: 255)]
    private ?string $hairColor = null;

    #[ORM\Column(length: 255)]
    private ?string $hatColor = null;

    #[ORM\Column(length: 255)]
    private ?string $accessories = null;

    #[ORM\Column(length: 255)]
    private ?string $accessoriesColor = null;

    #[ORM\Column(length: 255)]
    private ?string $facialHair = null;

    #[ORM\Column(length: 255)]
    private ?string $facialHairColor = null;

    #[ORM\Column(length: 255)]
    private ?string $clothing = null;

    #[ORM\Column(length: 255)]
    private ?string $clothingGrahpic = null;

    #[ORM\Column(length: 255)]
    private ?string $clothingColor = null;

    #[ORM\Column(length: 255)]
    private ?string $eyes = null;

    #[ORM\Column(length: 255)]
    private ?string $eyebrows = null;

    #[ORM\Column(length: 255)]
    private ?string $mouth = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getWidth(): ?int
    {
        return $this->width;
    }

    public function setWidth(int $width): self
    {
        $this->width = $width;

        return $this;
    }

    public function getHeight(): ?int
    {
        return $this->height;
    }

    public function setHeight(int $height): self
    {
        $this->height = $height;

        return $this;
    }

    public function getStyle(): ?string
    {
        return $this->style;
    }

    public function setStyle(string $style): self
    {
        $this->style = $style;

        return $this;
    }

    public function getBackground(): ?string
    {
        return $this->background;
    }

    public function setBackground(string $background): self
    {
        $this->background = $background;

        return $this;
    }

    public function getSvgBackground(): ?string
    {
        return $this->svgBackground;
    }

    public function setSvgBackground(string $svgBackground): self
    {
        $this->svgBackground = $svgBackground;

        return $this;
    }

    public function getSkin(): ?string
    {
        return $this->skin;
    }

    public function setSkin(string $skin): self
    {
        $this->skin = $skin;

        return $this;
    }

    public function getTop(): ?string
    {
        return $this->top;
    }

    public function setTop(string $top): self
    {
        $this->top = $top;

        return $this;
    }

    public function getHairColor(): ?string
    {
        return $this->hairColor;
    }

    public function setHairColor(string $hairColor): self
    {
        $this->hairColor = $hairColor;

        return $this;
    }

    public function getHatColor(): ?string
    {
        return $this->hatColor;
    }

    public function setHatColor(string $hatColor): self
    {
        $this->hatColor = $hatColor;

        return $this;
    }

    public function getAccessories(): ?string
    {
        return $this->accessories;
    }

    public function setAccessories(string $accessories): self
    {
        $this->accessories = $accessories;

        return $this;
    }

    public function getAccessoriesColor(): ?string
    {
        return $this->accessoriesColor;
    }

    public function setAccessoriesColor(string $accessoriesColor): self
    {
        $this->accessoriesColor = $accessoriesColor;

        return $this;
    }

    public function getFacialHair(): ?string
    {
        return $this->facialHair;
    }

    public function setFacialHair(string $facialHair): self
    {
        $this->facialHair = $facialHair;

        return $this;
    }

    public function getFacialHairColor(): ?string
    {
        return $this->facialHairColor;
    }

    public function setFacialHairColor(string $facialHairColor): self
    {
        $this->facialHairColor = $facialHairColor;

        return $this;
    }

    public function getClothing(): ?string
    {
        return $this->clothing;
    }

    public function setClothing(string $clothing): self
    {
        $this->clothing = $clothing;

        return $this;
    }

    public function getClothingGrahpic(): ?string
    {
        return $this->clothingGrahpic;
    }

    public function setClothingGrahpic(string $clothingGrahpic): self
    {
        $this->clothingGrahpic = $clothingGrahpic;

        return $this;
    }

    public function getClothingColor(): ?string
    {
        return $this->clothingColor;
    }

    public function setClothingColor(string $clothingColor): self
    {
        $this->clothingColor = $clothingColor;

        return $this;
    }

    public function getEyes(): ?string
    {
        return $this->eyes;
    }

    public function setEyes(string $eyes): self
    {
        $this->eyes = $eyes;

        return $this;
    }

    public function getEyebrows(): ?string
    {
        return $this->eyebrows;
    }

    public function setEyebrows(string $eyebrows): self
    {
        $this->eyebrows = $eyebrows;

        return $this;
    }

    public function getMouth(): ?string
    {
        return $this->mouth;
    }

    public function setMouth(string $mouth): self
    {
        $this->mouth = $mouth;

        return $this;
    }
}
