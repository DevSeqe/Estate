<?php

namespace EatFit\FrontBundle\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SiteController extends Controller
{
    public function indexAction()
    {
        return $this->render('FrontBundle:Site:index.html.twig');
    }
}
