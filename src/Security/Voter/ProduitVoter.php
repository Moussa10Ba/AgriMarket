<?php

namespace App\Security\Voter;

use App\Entity\Admin;
use App\Entity\Produit;
use App\Entity\Vendeur;
use App\Entity\Acheteur;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class ProduitVoter extends Voter
{
    protected function supports(string $attribute, $subject): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, ['POST_EDIT', 'POST_VIEW'])
            && $subject instanceof \App\Entity\Produit;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface  ) {
            return false;
        }

        $produit = $subject;

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case 'EDIT':
                return ($user === $produit->getOwner() || $user instanceof Admin);
                break;
            case 'VIEW':
                return ($user==$subject || $user instanceof Vendeur || $user instanceof Admin || $user instanceof Acheteur);
                break;
        }

        return false;
    }
}
