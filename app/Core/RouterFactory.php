<?php
declare(strict_types=1);

namespace App\Core;

use Nette\Application\Routers\RouteList;
use Nette\Application\Routers\Route;

final class RouterFactory
{
    public static function createRouter(): RouteList
    {
        $router = new RouteList;

        $router->addRoute('login', 'Sign:login');
        $router->addRoute('register', 'Sign:register');
        $router->addRoute('logout', 'Sign:out');

        // Turnaje
        $router->addRoute('tournaments', 'Tournament:Tournaments:default');
        $router->addRoute('tournament/detail/<id>', [
            'presenter' => 'Tournament',
            'action' => 'detail',
        ]);
        $router->addRoute('tournament/create', 'Tournament:create');

        // Týmy
        $router->addRoute('teams', 'Teams:default');
        $router->addRoute('team/create', 'Team:default');      // vytvoření týmu           // výpis týmů
        $router->addRoute('team/<id>', 'Teams:detail');        // detail týmu


        // Fórum a admin
        $router->addRoute('forum', 'Forum:default');
        $router->addRoute('forum/thread/<id>', 'Forum:thread');
        $router->addRoute('forum/create-thread', 'Forum:createThread');
        $router->addRoute('forum/post-reply/<id>', 'Forum:postReply');
        $router->addRoute('admin', 'Admin:default');

        // Domovská stránka
        $router->addRoute('<presenter>/<action>[/<id>]', 'Home:default');

        return $router;
    }
}