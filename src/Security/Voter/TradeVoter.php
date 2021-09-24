<?php

namespace App\Security\Voter;

use App\Entity\Trade;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class TradeVoter extends Voter
{
    protected function supports(string $attribute, $subject): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, ['TRADE_VIEW'])
            && $subject instanceof Trade;
    }

    /**
     * @param string $attribute
     * @param Trade $subject
     * @param TokenInterface $token
     * @return bool
     */
    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        // ... (check conditions and return true to grant permission) ...
        return match ($attribute) {
            'TRADE_VIEW' => $subject->getIsPublished() || $subject->getAuthor()?->getId() === $user->getId(),
            default => false,
        };

    }
}
