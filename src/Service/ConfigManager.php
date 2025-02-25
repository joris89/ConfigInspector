<?php

namespace ConfigInspectorBundle\Service;

class ConfigManager
{
    private array $loaders = [];

    public function addLoader(ConfigLoaderInterface $loader): self
    {
        $this->loaders[] = $loader;
        return $this;
    }

    public function loadAll(): array
    {
        $configData = [];

        foreach ($this->loaders as $loader) {
            $configData = array_merge($configData, $loader->load());
        }

        return $configData;
    }
}
