<?php

namespace Glide\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Config\Repository as ConfigRepository;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Routing\Router;


class TestInfrastructureCommand extends Command
{
    private UrlGenerator $urlGenerator;

    /**
     * @var string
     */
    protected $name = "qa:test-infrastructure";

    public function __construct(UrlGenerator $urlGenerator)
    {
        $this->urlGenerator = $urlGenerator;
        parent::__construct();
    }

    public function handle(): void
    {
        $this->testWebInterface();
    }

    private function testWebInterface()
    {
        $this->info("Testing web interface");
        $url     = $this->urlGenerator->route("qa.test-infrastructure");
        $content = file_get_contents($url);
        $success = $content === "";
        $this->printResult($success);
    }

    private function printResult(bool $success)
    {
        if ($success) {
            $this->info("✅");
        } else {
            $this->error("❌");
        }
    }

    public static function dropTable()
    {

    }

    public static function createTable()
    {

    }

    public static function insertInTable(int $id)
    {

    }

    public static function readFromTable(int $id)
    {

    }
}
