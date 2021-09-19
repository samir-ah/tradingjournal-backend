<?php

namespace App\Security\Voter;

use App\Entity\AuthorOwnedInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class UserOwnedVoter extends Voter
{
    public const CAN_EDIT = 'CAN_EDIT';

    protected function supports(string $attribute, $subject): bool
    {
        return in_array($attribute, [self::CAN_EDIT])
            && $subject instanceof AuthorOwnedInterface;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        $owner = $subject->getAuthor();
        return match ($attribute) {
            self::CAN_EDIT => $owner && $owner->getId() === $user->getId(),
            default => false,
        };

    }
}
