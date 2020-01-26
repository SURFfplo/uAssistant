<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DashboardsRepository")
 */
class Dashboards
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
     * @ORM\Column(type="boolean")
     */
    private $public;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $hidden;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Buttons", inversedBy="dashboards")
     */
    private $buttonsInDashboards;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="dashboards")
     * @ORM\JoinColumn(nullable=false)
     */
    private $userId;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\DashboardsFromUser", mappedBy="dashboardId", orphanRemoval=true)
     */
    private $dashboardsFromUsers;

    public function __construct()
    {
        $this->buttonsInDashboards = new ArrayCollection();
        $this->dashboardsFromUsers = new ArrayCollection();
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

    public function getPublic(): ?bool
    {
        return $this->public;
    }

    public function setPublic(bool $public): self
    {
        $this->public = $public;

        return $this;
    }

    public function getHidden(): ?bool
    {
        return $this->hidden;
    }

    public function setHidden(?bool $hidden): self
    {
        $this->hidden = $hidden;

        return $this;
    }

    /**
     * @return Collection|Buttons[]
     */
    public function getButtonsInDashboards(): Collection
    {
        return $this->buttonsInDashboards;
    }

    public function addButtonsInDashboard(Buttons $buttonsInDashboard): self
    {
        if (!$this->buttonsInDashboards->contains($buttonsInDashboard)) {
            $this->buttonsInDashboards[] = $buttonsInDashboard;
        }

        return $this;
    }

    public function removeButtonsInDashboard(Buttons $buttonsInDashboard): self
    {
        if ($this->buttonsInDashboards->contains($buttonsInDashboard)) {
            $this->buttonsInDashboards->removeElement($buttonsInDashboard);
        }

        return $this;
    }

    public function getUserId(): ?User
    {
        return $this->userId;
    }

    public function setUserId(?User $userId): self
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * @return Collection|DashboardsFromUser[]
     */
    public function getDashboardsFromUsers(): Collection
    {
        return $this->dashboardsFromUsers;
    }

    public function addDashboardsFromUser(DashboardsFromUser $dashboardsFromUser): self
    {
        if (!$this->dashboardsFromUsers->contains($dashboardsFromUser)) {
            $this->dashboardsFromUsers[] = $dashboardsFromUser;
            $dashboardsFromUser->setDashboardId($this);
        }

        return $this;
    }

    public function removeDashboardsFromUser(DashboardsFromUser $dashboardsFromUser): self
    {
        if ($this->dashboardsFromUsers->contains($dashboardsFromUser)) {
            $this->dashboardsFromUsers->removeElement($dashboardsFromUser);
            // set the owning side to null (unless already changed)
            if ($dashboardsFromUser->getDashboardId() === $this) {
                $dashboardsFromUser->setDashboardId(null);
            }
        }

        return $this;
    }
}
