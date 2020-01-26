<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DebutController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
        /*$nationaliteRepository = $em->getRepository('AppBundle:Nbvue');

        $nbvue=$nationaliteRepository->findOneBy(array('id' => 1));
        $nbvue->setNbvue($nbvue->getNbvue()+1);*/
        $em->flush();

        return $this->render('default/index.html.twig');
    }

    public function actuAction()
    {
        return $this->render('default/annonces.html.twig');
    }

    public function offreAction()
    {
        return $this->render('default/offres.html.twig');
    }

    public function propoAction()
    {
        return $this->render('default/propos.html.twig');
    }

    public function UPAction(){
        return $this->redirect('https://www.univ-poitiers.fr/');
    }
    public function contactAction(){
        return $this->redirect('webmaster@univ-poitiers.fr ');
    }
    public function iriafAction(){
        return $this->redirect('https://iriaf.univ-poitiers.fr/ ');
    }

}
