<?php

namespace Bit2Bit\CmsBundle\Command;

use Bit2Bit\CmsBundle\Entity\Page;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * 
 *
 * @author Paweł
 */
class PageCreateCommand extends ContainerAwareCommand {

    /**
     * Metoda konfigurująca komendę.
     */
    protected function configure() {
        $this
                ->setName('b2b:page:create')
                ->setDescription('Creates new page.');
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

        $name = $dialog->ask($output, '<fg=green>Please enter page name' . PHP_EOL . 'Name::</fg=green> ', '');
        $slug = $dialog->ask($output, '<fg=green>Please enter slug ' . PHP_EOL . 'Slug::</fg=green> ', false);

        $page = new Page();
        $page->setName($name)
                ->setSlug($slug);

        $em->persist($page);
        $em->flush();
        $output->writeln('<fg=green>Page added.</fg=green>');
    }

}
