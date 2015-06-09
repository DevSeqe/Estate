<?php

namespace Bit2Bit\NewsletterBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MessageController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('NewsletterBundle:Default:index.html.twig', array('name' => $name));
    }
}
