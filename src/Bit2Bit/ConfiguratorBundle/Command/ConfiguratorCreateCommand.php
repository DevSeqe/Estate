<?php

namespace Bit2Bit\ConfiguratorBundle\Command;

use Bit2Bit\ConfiguratorBundle\Entity\Setting;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * 
 *
 * @author Paweł
 */
class ConfiguratorCreateCommand extends ContainerAwareCommand {

    /**
     * Metoda konfigurująca komendę.
     */
    protected function configure() {
        $this
                ->setName('b2b:config:create')
                ->setDescription('Creates new key for configurator.');
    }

    /**
     * Polecenie 
     * 
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output) {
        $em = $this->getContainer()->get('doctrine')->getManager();

        $dialog = $this->getHelper('dialog');
       
        $settingKey = $dialog->ask($output, '<fg=green>Please enter setting key (group them by colon character eg. Group:Key) ' . PHP_EOL . 'Key::</fg=green> ', '');
        $settingName = $dialog->ask($output, '<fg=green>Please enter setting name (easy to read name) '. PHP_EOL . 'Name::</fg=green> ', false);
        $settingDesc = $dialog->ask($output, '<fg=green>Setting description (optional, for more complex setting values) '. PHP_EOL . 'Description::</fg=green> ', '');

        $setting = new Setting();
        $setting->setKey($settingKey)
                ->setName($settingName)
                ->setDescription($settingDesc)
                ->setValue('');
        
        $em->persist($setting);
        $em->flush();
        $output->writeln('<fg=green>Setting added.</fg=green>');
    }

}
