<?php

namespace Bit2Bit\ConfiguratorBundle\Command;

use Bit2Bit\BaseBundle\Base\FileGenerator;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * 
 *
 * @author Paweł
 */
class ConfiguratorListCommand extends ContainerAwareCommand {

    /**
     * Metoda konfigurująca komendę.
     */
    protected function configure() {
        $this
                ->setName('b2b:config:list')
                ->setDescription('Display list of all configurator keys.');
    }

    /**
     * Polecenie 
     * 
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output) {                
        $em = $this->getContainer()->get('doctrine')->getRepository('ConfiguratorBundle:Setting');
        $settings = $em->findBy(array(),array('key'=>'ASC'));
        foreach($settings as $setting){
            if(strpos($setting->getKey(), ':') === false){
                $output->writeln('');
                $output->writeln('<fg=green>/**</fg=green>');
                $output->writeln('<fg=green> * '.$setting->getName().'</fg=green>');
                $output->writeln('<fg=green> *</fg=green>');
                $output->writeln('<fg=green> * '.$setting->getDescription().'</fg=green>');
                $output->writeln('<fg=green> */</fg=green>');
            }
            else{
                $output->writeln("\t<fg=green>".str_pad('['.$setting->getKey().']',30)."</fg=green>\t".$setting->getName());                
            }
        }
//        var_dump($settings);
//        $output->writeln('This command will generate  entity.');
    }

}
