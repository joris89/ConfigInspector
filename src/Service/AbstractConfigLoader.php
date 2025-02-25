<?php

namespace ConfigInspectorBundle\Service;

use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Yaml;

abstract class AbstractConfigLoader implements ConfigLoaderInterface
{
    protected string $projectDir;
    protected string $env;

    public function __construct(string $projectDir, string $env = '')
    {
        $this->projectDir = $projectDir;
        $this->env = $env;
    }

    abstract protected function getFilePaths(): array;

    public function load(): array
    {
        $configData = [];

        foreach ($this->getFilePaths() as $label => $filePath) {
            $configData[$label] = $this->loadYamlFile($filePath);
        }

        return $configData;
    }

    protected function loadYamlFile(string $filePath): array
    {
        if (!file_exists($filePath)) {
            return [];
        }

        try {
            return Yaml::parseFile($filePath, Yaml::PARSE_CONSTANT);
        } catch (ParseException $e) {
            return ["⚠ Fehler beim Parsen von $filePath" => $e->getMessage()];
        }
    }
}
