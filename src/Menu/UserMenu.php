<?php

namespace Rock\Menu;

use Braunstetter\MenuBundle\Factory\MenuItem;
use Braunstetter\MenuBundle\Menu;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Traversable;

class UserMenu extends Menu
{
    private AuthorizationCheckerInterface $authorizationChecker;

    public function __construct(AuthorizationCheckerInterface $authorizationChecker)
    {
        parent::__construct();


        $this->authorizationChecker = $authorizationChecker;
    }

    public function define(): Traversable
    {
        yield MenuItem::linkToRoute('Profile', 'cp_dashboard');

        if ($this->authorizationChecker->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            yield MenuItem::linkToRoute('Logout', 'app_logout');
        }
    }
}