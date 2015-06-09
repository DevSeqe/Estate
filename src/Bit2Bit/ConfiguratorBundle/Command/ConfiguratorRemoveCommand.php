<?php

namespace Bit2Bit\ConfiguratorBundle\Command;

use Bit2Bit\BaseBundle\Base\FileGenerator;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * 
 *
 * @author Paweł
 */
class ConfiguratorRemoveCommand extends ContainerAwareCommand {

    /**
     * Metoda konfigurująca komendę.
     */
    protected function configure() {
        $this
                ->setName('b2b:config:remove')
                ->setDescription('Remove setting with given key.')
                ->addArgument(
                        'key', InputArgument::REQUIRED, 'Setting key'
        );
    }

    /**
     * Polecenie 
     * 
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output) {
        $key = $input->getArgument('key');
        $em = $this->getContainer()->get('doctrine')->getRepository('ConfiguratorBundle:Setting');
        $setting = $em->findOneByKey($key);
        
        if(!$setting){
            $output->writeln('<bg=red>There is no setting with that key.</bg=red>');
        }
        else{
            $em = $this->getContainer()->get('doctrine')->getManager();
            $em->remove($setting);
            $em->flush();
            $output->writeln('<bg=green>Setting removed.</bg=green>');
        }
    }

}
