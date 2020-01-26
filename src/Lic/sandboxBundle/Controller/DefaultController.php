<?php

namespace Lic\sandboxBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('@Licsandbox/Default/index.html.twig.twig');
    }

    public function actuAction()
    {
        return $this->render('@Licsandbox/Default/annonces.html.twig');
    }

    public function offreAction()
    {
        return $this->render('@Licsandbox/Default/offres.html.twig');
    }

    public function propoAction()
    {
        return $this->render('@Licsandbox/Default/propos.html.twig');
    }

}
