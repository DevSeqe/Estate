<?php

namespace Bit2Bit\OfferBundle\Controller;

use Bit2Bit\MainBundle\Base\AbstractController;

class GalleryController extends AbstractController {

    const NAME = 'OfferBundle:Gallery';

    public function connectorAction() {
        $opts = array(
            'locale' => 'en_US.UTF-8',
            'bind' => array(
                'mkdir mkfile rename duplicate upload rm paste' => 'logger'
            ),
            'debug' => true,
            'roots' => array(
                array(
                    'driver' => 'LocalFileSystem',
                    'path' => '/home/seqepi/ftp/zapisywacz/hdd',
                    'alias' => 'Zapisywacz',
                    'mimeDetect' => 'internal',
                    'tmbPath' => '.tmb',
                    'utf8fix' => true,
                    'tmbCrop' => false,
                    'startPath' => '/home/seqepi/ftp/zapisywacz/hdd',
                    'attributes' => array(
                        array(
                            'pattern' => '~/\.~',
                            'read' => false,
                            'write' => false,
                            'hidden' => true,
                            'locked' => false
                        ),
                        array(
                            'pattern' => '~/replace/.+png$~',
                            'read' => false,
                            'write' => false,
                            'locked' => true
                        )
                    ),
                ),
            )
        );



// sleep(3);
        header('Access-Control-Allow-Origin: *');
        $connector = new elFinderConnector(new elFinder($opts), true);
        $connector->run();
    }

}
