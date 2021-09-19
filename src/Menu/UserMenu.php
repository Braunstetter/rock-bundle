<?php

namespace Rock\Menu;

use Braunstetter\MenuBundle\Factory\MenuItem;
use Braunstetter\MenuBundle\Menu;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use Traversable;

class UserMenu extends Menu
{
    private AuthorizationCheckerInterface $authorizationChecker;
    private TranslatorInterface $translator;

    public function __construct(AuthorizationCheckerInterface $authorizationChecker, TranslatorInterface $translator)
    {
        parent::__construct();

        $this->authorizationChecker = $authorizationChecker;
        $this->translator = $translator;
    }

    public function define(): Traversable
    {
        if ($this->authorizationChecker->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            yield MenuItem::linkToRoute(
                ucfirst($this->translator->trans('logout', [], 'cp')),
                'app_logout'
            );
        }
    }
}