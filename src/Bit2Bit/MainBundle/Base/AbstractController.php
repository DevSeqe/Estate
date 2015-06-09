<?php

namespace Bit2Bit\MainBundle\Base;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class AbstractController extends Controller {

    public function json($array = array()) {
        $response = new JsonResponse();
        return $response->setData($array);
    }

}
