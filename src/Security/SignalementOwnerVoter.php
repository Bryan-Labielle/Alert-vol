<?php

namespace App\Security;

use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;

class SignalementOwnerVoter extends Voter
{
    public const ROLE_SIGNALEMENT = 'ROLE_SIGNALEMENT';
    private $security;
    /**
     * EmailVerifiedVoter constructor.
     */
    public function __construct(Security $security)
    {
        $this->security = $security;
    }


    protected function supports(string $attribute, $subject)
    {
        // if the attribute isn't one we support, return false
        if (!in_array($attribute, [self::ROLE_SIGNALEMENT])) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();
        if (!$user instanceof User) {
            // the user must be logged in; if not, deny access
            return false;
        }
        if ($this->security->isGranted('ROLE_SUPER_ADMIN')) {
            return true;
        }
        if ($subject->annonce->getOwner() === $user) {
            return true;
        }
        return $subject->signalement->getOwner() === $user;
    }
}
