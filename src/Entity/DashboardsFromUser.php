<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DashboardsFromUserRepository")
 * @Gedmo\Loggable
 */
class DashboardsFromUser
{
    use TimestampableEntity;
    use BlameableEntity;
    use SoftDeleteableEntity;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="dashboardsFromUsers")
     * @ORM\JoinColumn(nullable=false)
     * @Gedmo\Versioned
     */
    private $userId;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Dashboards", inversedBy="dashboardsFromUsers")
     * @ORM\JoinColumn(nullable=false)
     * @Gedmo\Versioned
     */
    private $dashboardId;

    /**
     * @ORM\Column(type="string", length=255)
     * @Gedmo\Versioned
     */
    private $userRole;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $position;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDashboardId(): ?Dashboards
    {
        return $this->dashboardId;
    }

    public function setDashboardId(?Dashboards $dashboardId): self
    {
        $this->dashboardId = $dashboardId;

        return $this;
    }

    public function getUserRole(): ?string
    {
        return $this->userRole;
    }

    public function setUserRole(string $userRole): self
    {
        $this->userRole = $userRole;

        return $this;
    }

    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function setPosition(?int $position): self
    {
        $this->position = $position;

        return $this;
    }
}
