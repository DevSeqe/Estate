<?php

namespace Bit2Bit\CmsBundle\Controller;

use Bit2Bit\CmsBundle\Entity\Page;
use Bit2Bit\CmsBundle\Form\PageType;
use Bit2Bit\CmsBundle\Manager\PageManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PageController extends Controller {

    const NAME = 'CmsBundle:Page';

    public function indexAction() {
        $pageManager = $this->get(PageManager::SERVICE); /* @var $pageManager PageManager */
        $pages = $pageManager->findAll(); /* @var $pages Page[] */
        return $this->render(self::NAME . ':index.html.twig', array('pages' => $pages));
    }

    public function editAction(Request $request, $id) {
        $pageManager = $this->get(PageManager::SERVICE); /* @var $pageManager PageManager */
        $page = $pageManager->find($id); /* @var $page Page */

        $session = $this->get('session');

        if (!$page) {
            $session->getFlashBag()->add('danger', 'Nie odnaleziono strony.');
            return $this->redirect($this->generateUrl('page'));
        }

        $form = $this->createForm(new PageType(), $page, array(
            'action' => $this->generateUrl('page_edit', array('id' => $id)),
            'method' => 'POST',
        ));
        $form->handleRequest($request);

        if ($form->isValid()) {
            $pageManager->update($page);
            $session->getFlashBag()->add('success', 'Zaktualizowano stronę.');
            return $this->redirect($this->generateUrl('page'));
        }
        return $this->render(self::NAME . ':edit.html.twig', array(
                    'form' => $form->createView(),
        ));
    }
    
    public function manageDiplomasAction(){        
        return $this->render(self::NAME . ':diplomas.html.twig');
    }
}
