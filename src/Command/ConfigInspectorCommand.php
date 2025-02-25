<?php

namespace ConfigInspectorBundle\Command;

use ConfigInspectorBundle\Service\ConfigManager;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'config:inspect',
    description: 'Zeigt alle geladenen Symfony-Konfigurationswerte für die aktuelle Umgebung an.'
)]
class ConfigInspectorCommand extends Command
{
    private ConfigManager $configManager;

    public function __construct(ConfigManager $configManager)
    {
        parent::__construct();
        $this->configManager = $configManager;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $configData = $this->configManager->loadAll();

        foreach ($configData as $source => $values) {
            $io->section("🔍 Quelle: $source");
            $this->printFormattedConfig($values, 2, $output);
        }

        return Command::SUCCESS;
    }

    private function printFormattedConfig(array $data, int $indent, OutputInterface $output): void
    {
        foreach ($data as $key => $value) {
            $prefix = str_repeat(' ', $indent);
            if (is_array($value)) {
                $output->writeln("$prefix$key:");
                $this->printFormattedConfig($value, $indent + 2, $output);
            } else {
                $output->writeln("$prefix$key: $value");
            }
        }
    }
}
