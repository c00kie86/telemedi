<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Finder\Finder;

class DumpFileContentCommand extends Command
{
    protected static $defaultName = 'config:dump-file-content';

    protected function configure(): void
    {
        $this
            ->setDescription('Zrzut zawartości wszystkich plików z podanego katalogu')
            ->addArgument('path', InputArgument::REQUIRED, 'Wymagana podania ścieżki do katalogu');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $path = $input->getArgument('path');

        if (!is_dir($path)) {
            $output->writeln("Podana ścieżka nie istnieje lub nie jest katalogiem: {$path}");
            return 1; // FAILURE
        }

        $finder = new Finder();
        $finder->files()->in($path);

        $allContent = '';

        foreach ($finder as $file) {
            $relativePath = $file->getRelativePathname();

            try {
                $content = $file->getContents();
            } catch (\Exception $e) {
                $content = "[Błąd odczytu pliku: {$e->getMessage()}]";
            }

            $allContent .= "=== {$relativePath} ===\n";
            $allContent .= $content . "\n\n";
        }

        $output->writeln($allContent);
        return 0; // SUCCESS
    }
}
