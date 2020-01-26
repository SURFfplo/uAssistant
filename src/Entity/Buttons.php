<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ButtonsRepository")
 */
class Buttons
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $icon;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $url;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Dashboards", mappedBy="buttonsInDashboards")
     */
    private $dashboards;

    public function __construct()
    {
        $this->dashboards = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getIcon(): ?string
    {
        return $this->icon;
    }

    public function setIcon(string $icon): self
    {
        $this->icon = $icon;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @return Collection|Dashboards[]
     */
    public function getDashboards(): Collection
    {
        return $this->dashboards;
    }

    public function addDashboard(Dashboards $dashboard): self
    {
        if (!$this->dashboards->contains($dashboard)) {
            $this->dashboards[] = $dashboard;
            $dashboard->addButtonsInDashboard($this);
        }

        return $this;
    }

    public function removeDashboard(Dashboards $dashboard): self
    {
        if ($this->dashboards->contains($dashboard)) {
            $this->dashboards->removeElement($dashboard);
            $dashboard->removeButtonsInDashboard($this);
        }

        return $this;
    }
}
