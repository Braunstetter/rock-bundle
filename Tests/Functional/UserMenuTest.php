<?php

namespace Rock\Tests\Functional;

use Rock\Menu\UserMenu;
use Symfony\Component\Security\Core\User\InMemoryUser;

class UserMenuTest extends AbstractWebTestCase
{

    public function test_menu_shows_correct_items()
    {

        $client = $this->createClient(['test_case' => 'general', 'root_config' => 'config.yml']);
        $user = new InMemoryUser('dunglas', 'foo');

        $userMenu = $client->getContainer()->get(UserMenu::class);

        $resolvedMenu = iterator_to_array($userMenu->define());
        $this->assertCount(0, $resolvedMenu);

        $client->loginUser($user);

        $resolvedMenu = iterator_to_array($userMenu->define());
        $this->assertCount(1, $resolvedMenu);
        $this->assertSame('Logout', $resolvedMenu[0]->getLabel());
    }

    public function test_translation_of_menu_works()
    {
        $client = $this->createClient(['test_case' => 'general', 'root_config' => 'config.de.yml']);
        $user = new InMemoryUser('dunglas', 'foo');

        $userMenu = $client->getContainer()->get(UserMenu::class);
        $client->loginUser($user);

        $resolvedMenu = iterator_to_array($userMenu->define());
        $this->assertSame('Ausloggen', $resolvedMenu[0]->getLabel());
    }
}
