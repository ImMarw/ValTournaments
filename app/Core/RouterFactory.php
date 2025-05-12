<?php
namespace App\Core;

use Nette;
use Nette\Application\Routers\RouteList;
use Nette\Application\Routers\Route;

// app/Core/RouterFactory.php

final class RouterFactory
{
    public static function createRouter(): \Nette\Application\Routers\RouteList
    {
        $router = new \Nette\Application\Routers\RouteList;
        $router->addRoute('', 'Home:default');

        // authentication
        $router->addRoute('login',    'Login:default');
        $router->addRoute('register', 'Register:default');
        $router->addRoute('logout',   'Logout:default');

        $router->addRoute('teams',              'Teams:default');
        $router->addRoute('team/create',        'Teams:create');
        $router->addRoute('team/<id>',          'Teams:detail');
        $router->addRoute('my-team',            'Teams:myTeam');
        $router->addRoute('team/<id>/edit', 'Teams:edit');

        $router->addRoute('invitations',        'Invite:list');
        $router->addRoute('invitation/<token>', 'Invite:respond');

        $router->addRoute('forum', 'Forum:default');
        $router->addRoute('forum/create', 'Forum:create');
        $router->addRoute('forum/<id>', 'Forum:topic');

        $router->addRoute('tournaments', 'Tournaments:default');
        $router->addRoute('tournaments/create', 'Tournaments:create');
        $router->addRoute('tournaments/<id>/edit', 'Tournaments:edit');
        $router->addRoute('tournaments/<id>', 'Tournaments:detail');

        $router->addRoute('admin', [
            'presenter' => 'Admin',
            'action'    => 'default',
        ]);

        $router->addRoute('admin/users', [
            'presenter' => 'Admin',
            'action'    => 'users',
        ]);
        $router->addRoute('admin/teams', [
            'presenter' => 'Admin',
            'action'    => 'teams',
        ]);
        $router->addRoute('admin/tournaments', [
            'presenter' => 'Admin',
            'action'    => 'tournaments',
        ]);

        return $router;
    }
}