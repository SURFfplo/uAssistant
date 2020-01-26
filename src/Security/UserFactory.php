<?php

namespace App\Security;

use App\Entity\User;
use Hslavich\OneloginSamlBundle\Security\Authentication\Token\SamlTokenInterface;
use Hslavich\OneloginSamlBundle\Security\User\SamlUserFactoryInterface;

class UserFactory implements SamlUserFactoryInterface
{
    public function createUser(SamlTokenInterface $token)
    {
        $attributes = $token->getAttributes();
        $user = new User();
        $user->setRoles(array('ROLE_USER'));
        $user->setUsername($token->getUsername());
        return $user;
    }
}