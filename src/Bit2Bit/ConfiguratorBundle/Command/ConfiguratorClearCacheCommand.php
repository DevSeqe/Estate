<?php

namespace Bit2Bit\ConfiguratorBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * 
 *
 * @author Paweł
 */
class ConfiguratorClearCacheCommand extends ContainerAwareCommand {

    /**
     * Metoda konfigurująca komendę.
     */
    protected function configure() {
        $this
                ->setName('b2b:config:clear')
                ->setDescription('Clear cache for settings.');
    }

    /**
     * Polecenie 
     * 
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output) {

        //Define your file path based on the cache one
        $setFile = $this->container->getParameter('kernel.cache_dir') . '/b2b/settings';
        if(file_exists($setFile)){
            unlink($setFile);
        }
        $output->writeln('Settings cache cleared.');
    }
}
