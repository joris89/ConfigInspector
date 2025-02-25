<?php

namespace ConfigInspectorBundle\Service;

use Symfony\Component\Dotenv\Dotenv;

class EnvConfigLoader implements ConfigLoaderInterface
{
    private string $projectDir;

    public function __construct(string $projectDir)
    {
        $this->projectDir = $projectDir;
    }

    public function load(): array
    {
        $envFile = "{$this->projectDir}/.env";
        if (!file_exists($envFile)) {
            return [];
        }

        try {
            $dotenv = new Dotenv();
            return ['.env' => $dotenv->parse(file_get_contents($envFile))];
        } catch (\Exception $e) {
            return ["⚠ Fehler beim Parsen der .env Datei" => $e->getMessage()];
        }
    }
}
