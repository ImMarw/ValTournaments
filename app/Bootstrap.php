<?php
declare(strict_types=1);

namespace App;

use Nette;
use Nette\Bootstrap\Configurator;
use Nette\DI\Compiler;
use Nette\Bridges\SecurityDI\SecurityExtension;

class Bootstrap
{
    private Configurator $configurator;
    private string $rootDir;

    public function __construct()
    {
        $this->rootDir = dirname(__DIR__);
        $this->configurator = new Configurator;
        $this->configurator->setTempDirectory($this->rootDir . '/temp');
    }

    public function bootWebApplication(): Nette\DI\Container
    {
        $this->initializeEnvironment();
        $this->setupContainer();
        return $this->configurator->createContainer();
    }

    private function initializeEnvironment(): void
    {
        $this->configurator->enableTracy($this->rootDir . '/log');
        $this->configurator->createRobotLoader()
            ->addDirectory(__DIR__)
            ->register();
    }

    private function setupContainer(): void
    {

        // 2) load configuration files
        $configDir = $this->rootDir . '/config';
        $this->configurator->addConfig($configDir . '/common.neon');
        $this->configurator->addConfig($configDir . '/services.neon');
    }
}