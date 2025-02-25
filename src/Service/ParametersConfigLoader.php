<?php

namespace ConfigInspectorBundle\Service;

class ParametersConfigLoader extends AbstractConfigLoader
{
    protected function getFilePaths(): array
    {
        return [
            'parameters.yaml' => "{$this->projectDir}/config/parameters.yaml",
            "parameters_{$this->env}.yaml" => "{$this->projectDir}/config/parameters_{$this->env}.yaml",
        ];
    }
}
