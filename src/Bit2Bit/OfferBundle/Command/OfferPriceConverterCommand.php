<?php

namespace Bit2Bit\OfferBundle\Command;

use Bit2Bit\BaseBundle\Base\FileGenerator;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * 
 *
 * @author Paweł
 */
class OfferPriceConverterCommand extends ContainerAwareCommand {

    /**
     * Metoda konfigurująca komendę.
     */
    protected function configure() {
        $this
                ->setName('b2b:offer:convert')
                ->setDescription('Convert prices from previous system to new one..');
    }

    /**
     * Polecenie 
     * 
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output) {  
        $manager = $this->getContainer()->get('doctrine')->getManager();
        $em = $this->getContainer()->get('doctrine')->getRepository('OfferBundle:Offer');
        $offers = $em->findAll();
        foreach($offers as $offer){
            $offer->setTotalPrice($offer->getPricePerMeter()*$offer->getArea());
            $manager->flush();
        }
        $output->writeln('Done.');
    }

}
