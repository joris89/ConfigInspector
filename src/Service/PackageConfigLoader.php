<?php

namespace ConfigInspectorBundle\Service;

use Symfony\Component\Finder\Finder;

class PackageConfigLoader extends AbstractConfigLoader
{
    protected function getFilePaths(): array
    {
        $configFiles = [];

        $finder = new Finder();
        $finder->files()->in("{$this->projectDir}/config/packages")->name('*.yaml');

        $envConfigPath = "{$this->projectDir}/config/packages/{$this->env}";
        if (is_dir($envConfigPath)) {
            $finder->files()->in($envConfigPath)->name('*.yaml');
        }

        foreach ($finder as $file) {
            $configFiles["config/{$file->getFilename()}"] = $file->getRealPath();
        }

        return $configFiles;
    }
}
