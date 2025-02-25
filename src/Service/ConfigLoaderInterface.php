<?php

namespace ConfigInspectorBundle\Service;

interface ConfigLoaderInterface
{
    public function load(): array;
}