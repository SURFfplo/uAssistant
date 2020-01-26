<?php

namespace App\Security;

use App\Entity\Dashboards;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class DashboardVoter extends Voter
{

    // these strings are just invented: you can use anything
    const VIEW = 'view';
    const EDIT = 'edit';

    protected function supports($attribute, $subject)
    {
        // if the attribute isn't one we support, return false
        if (!in_array($attribute, [self::VIEW, self::EDIT])) {
            return false;
        }

        // only vote on Dashboards objects inside this voter
        if (!$subject instanceof Dashboards) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();

        if (!$user instanceof User) {
            // the user must be logged in; if not, deny access
            return false;
        }

        // you know $subject is a Dashboards object, thanks to supports
        /** @var Dashboards $dashboard */
        $dashboard = $subject;

        switch ($attribute) {
            case self::VIEW:
                return $this->canView($dashboard, $user);
            case self::EDIT:
                return $this->canEdit($dashboard, $user);
        }

        throw new \LogicException('This code should not be reached!');
    }

    private function canView(Dashboards $dashboard, User $user)
    {
        // if they can edit, they can view
        if ($this->canEdit($dashboard, $user)) {
           return true;
        }

        // the Post object could have, for example, a method isPrivate()
        // that checks a boolean $private property
        return $dashboard->getPublic();
    }

    private function canEdit(Dashboards $dashboard, User $user)
    {
        // this assumes that the data object has a getOwner() method
        // to get the entity of the user who owns this data object
        return $user === $dashboard->getUserId();
    }
}