<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @Gedmo\Loggable
 */
class User implements UserInterface
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
     * @ORM\Column(type="string", length=180, unique=true)
     * @Gedmo\Versioned
     */
    private $username;

    /**
     * @ORM\Column(type="json")
     * @Gedmo\Versioned
     */
    private $roles = [];

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Dashboards", mappedBy="userId")
     */
    private $dashboards;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\DashboardsFromUser", mappedBy="userId", orphanRemoval=true)
     */
    private $dashboardsFromUsers;

    public function __construct()
    {
        $this->dashboards = new ArrayCollection();
        $this->dashboardsFromUsers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword()
    {
        // not needed for apps that do not check user passwords
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed for apps that do not check user passwords
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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
            $dashboard->setUserId($this);
        }

        return $this;
    }

    public function removeDashboard(Dashboards $dashboard): self
    {
        if ($this->dashboards->contains($dashboard)) {
            $this->dashboards->removeElement($dashboard);
            // set the owning side to null (unless already changed)
            if ($dashboard->getUserId() === $this) {
                $dashboard->setUserId(null);
            }
        }

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
            $dashboardsFromUser->setUserId($this);
        }

        return $this;
    }

    public function removeDashboardsFromUser(DashboardsFromUser $dashboardsFromUser): self
    {
        if ($this->dashboardsFromUsers->contains($dashboardsFromUser)) {
            $this->dashboardsFromUsers->removeElement($dashboardsFromUser);
            // set the owning side to null (unless already changed)
            if ($dashboardsFromUser->getUserId() === $this) {
                $dashboardsFromUser->setUserId(null);
            }
        }

        return $this;
    }
}
