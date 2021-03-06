<?php

namespace App\Security\Voter;

use App\Entity\Admin;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class VendeurVoter extends Voter
{
    protected function supports(string $attribute, $subject): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, ['EDIT', 'VIEW', 'DELETE_'])
            && $subject instanceof \App\Entity\Vendeur;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case 'EDIT':
                return ($user===$subject || $user instanceof Admin);
                break;
            case 'VIEW':
                    return ($user===$subject || $user instanceof Admin);
                break;
            case 'DELETE_':
                    return ($user instanceof Admin);
                break;
        }

        return false;
    }
}
