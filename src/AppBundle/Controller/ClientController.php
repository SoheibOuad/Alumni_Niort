<?php


namespace AppBundle\Controller;


use AppBundle\Entity\Annonce;
use AppBundle\Entity\Commentaire;
use AppBundle\Entity\Competence;
use AppBundle\Entity\Mail;
use AppBundle\Entity\NationaliteUser;
use AppBundle\Entity\Offre;
use AppBundle\Entity\Poste;
use AppBundle\Entity\Postule;
use AppBundle\Entity\Telephone;
use Intervention\Image\ImageManagerStatic as Image;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Validator\Constraints\DateTime;

class ClientController extends Controller
{

    public function offresAction(Request $request){

        $em = $this->getDoctrine()->getEntityManager();
        $listeoffreRepository = $em->getRepository('AppBundle:Offre');
        $offres = $listeoffreRepository->findAll();

        /**
         * @var $paginator \Knp\Component\Pager\Paginator
         */
        $paginator = $this->get('knp_paginator');

        $result=$paginator->paginate(
            $offres ,
            $request->query->getInt('page',1),
            $request->query->getInt('limit',3)
        );


        return $this->render('users/offres.html.twig',['offres' => $result]);

    }


    public function offreSpecialAction($id){

        $em = $this->getDoctrine()->getEntityManager();
        $UtilisateurRepository = $em->getRepository('AppBundle:Offre');
        $offre = $UtilisateurRepository->find(array('id' => $id));

        $offre->setNbvue($offre->getNbvue()+1);
        $user=$offre->getUtilisateur();
        $em->flush();

        return $this->render('users/offresSpecial.html.twig',['offre' => $offre , 'user'=>$user ,'id'=>$id]);

    }

    public function offreSpecPosSignAction(Request $request){




            $em = $this->getDoctrine()->getEntityManager();
        $UtilisateurRepository = $em->getRepository('AppBundle:Offre');
        $offre = $UtilisateurRepository->find(array('id' => $request->request->get('id')));
            $postule = new Postule();

            $curentid=$this->getUser()->getId();

            $postule->setUtilisateur($this->getUser());
            $postule->setOffre($offre);

           $em->persist($postule);

           $em->flush();

        $response = new Response(json_encode(array(
            'ok' => "ok"
        )));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    public function offreSpecPosSign2Action(Request $request){
        $em = $this->getDoctrine()->getEntityManager();

        $UtilisateurRepository = $em->getRepository('AppBundle:Offre');
        $offre = $UtilisateurRepository->find(array('id' => $request->request->get('id')));

        $listeuserRepository = $em->getRepository('AppBundle:User');
        $user = $listeuserRepository->findAll();
        $userEnvoyer=null;
        $i=0;

        $curentid=$this->getUser()->getId();
        foreach ($user as $u){

            if($u->getId()!= $curentid && $this->userHasRole($u->getId(),"ROLE_ADMIN")==true){
                $userEnvoyer[$i]=$u;
                $i++;
            }
        }

        $offre->setSignale(1);
        $em->flush();

        // Instantiation and passing `true` enables exceptions
        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->SMTPDebug = 2;                                       // Enable verbose debug output
            $mail->isSMTP();                                            // Set mailer to use SMTP
            $mail->Host       = 'smtp.outlook.com;smtp.hotmail.com;smpt.gmail.com';  // Specify main and backup SMTP servers
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username   = 'privrisk.iriaf@outlook.fr';                     // SMTP username
            $mail->Password   = 'PrivRiskIriaf2019';                               // SMTP password
            $mail->SMTPSecure = 'tls';                                  // Enable TLS encryption, `ssl` also accepted
            $mail->Port       = 587;                                    // TCP port to connect to

            //Recipients
            $mail->setFrom('privrisk.iriaf@outlook.fr', 'Mailer');
            // Add a recipient
            for ($i=0;$i<sizeof($userEnvoyer);$i++) {
                $mail->addAddress($userEnvoyer[$i]->getEmail());               // Name is optional
            }


            /* // Attachments
             $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
             $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name*/

            // $email = file_get_contents('inscription.html.twig' );

            // Remplacement des valeurs


            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'Priv Risk : Signal offre ';
            $mail->Body    = " Bonjour Monsieur Administrateur<br>
                           \L'un des membres de priv'Risk a signalé un offre , Veuillez vous connectez sur votre compte pour avoir plus de détails . Merci ! <br>
                           ne repondez pas sur cet email ." ;
            //$mail->Body = preg_replace( array_keys( $replacements ), array_values( $replacements ), $email );
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();
            echo 'Message has been sent';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }


        $response = new Response(json_encode(array(
            'ok' => "ok"
        )));
        $response->headers->set('Content-Type', 'application/json');

        return $response;


    }

    public function userHasRole($id,$role){

        $em=$this->getDoctrine()->getManager();
        $qb= $em->createQueryBuilder();

        $qb->select('u')
            ->from('AppBundle:User','u')
            ->where('u.id= :user')
            ->andWhere('u.roles LIKE :roles')
            ->setParameter('user',$id)
            ->setParameter('roles','%"'.$role.'"%');

        $user =$qb->getQuery()->getResult();
        if(count($user) >=1){
            return true ;
        }else{
            return false ;
        }
    }

    public function actualiteAction(Request $request){

        $em = $this->getDoctrine()->getEntityManager();
        $listeoffreRepository = $em->getRepository('AppBundle:Annonce');
        $acualites = $listeoffreRepository->findAll();

        /**
         * @var $paginator \Knp\Component\Pager\Paginator
         */

        $paginator = $this->get('knp_paginator');

        $result=$paginator->paginate(
            $acualites ,
            $request->query->getInt('page',1),
            $request->query->getInt('limit',3)
        );



        return $this->render('users/actualite.html.twig',['acualites' => $result]);
    }

    public function annonceSpecialAction($id){


        $em = $this->getDoctrine()->getEntityManager();
        $UtilisateurRepository = $em->getRepository('AppBundle:Annonce');
        $annonce = $UtilisateurRepository->find(array('id' => $id));

        $user=$annonce->getUtilisateur();
        $em->flush();


        $CommRepository = $em->getRepository('AppBundle:Commentaire');
        $commentaire = $CommRepository->findBy(array('annonce' => $annonce));


        $Tabuser=null;

        for ($i=0;$i<sizeof($commentaire);$i++){
            $Tabuser[$i]=$commentaire[$i];
        }
        $em->flush();
        return $this->render('users/annonceSpecial.html.twig',['annonce' => $annonce , 'user'=>$user ,'id'=>$id , 'commentaire'=>$commentaire , 'user2'=>$Tabuser]);


    }


    public function annonceCommenteAction(Request $request){

        $em = $this->getDoctrine()->getEntityManager();

        $UtilisateurRepository = $em->getRepository('AppBundle:User');
        $user = $UtilisateurRepository->find(array('id' => $request->request->get('iduser')));

        $AnnonceRepository = $em->getRepository('AppBundle:Annonce');
        $annonce = $AnnonceRepository->find(array('id' => $request->request->get('idannonce')));

        $Commentaire = new Commentaire();

        $Commentaire->setUtilisateur($user);
        $Commentaire->setAnnonce($annonce);
        $Commentaire->setCommentaire($request->request->get('comment'));




        $Commentaire->setDate(new \DateTime('now'));
        $em->persist($Commentaire);

        $em->flush();

        $response = new Response(json_encode(array(
            'ok' => "ok"
        )));
        $response->headers->set('Content-Type', 'application/json');

        return $response;


    }

    public function mesoffresAction(){
        $em = $this->getDoctrine()->getEntityManager();
        $listePanierRepository = $em->getRepository('AppBundle:Offre');
        $liste = $listePanierRepository->findBy(array('utilisateur' =>$this->getUser() ));
         $Mesoffres=null;
        for($i=0;$i<sizeof($liste);$i++){
            $Mesoffres[$i]=$liste[$i];
        }



        return $this->render('users/mesOffres.html.twig' ,['offres' => $Mesoffres]);

    }

    public function gererMesOffresAction(Request $request){

       if($request->request->get('modifier')=="mod"){
           dump("helloo 1");
           die();
       }else if ($request->request->get('supprimer')=="supp"){
           dump("hello 2");
           die();
       }


        return $this->render('users/mesOffres.html.twig');
    }

    public function suppMesOffresAction(Request $request){

        $em = $this->getDoctrine()->getEntityManager();
        $offre= $em->find('AppBundle:Offre', $request->request->get('id'));

        $em->remove($offre);

        $em->flush();

        $this->get('session')->getFlashBag()->add(
            'success',
            "L'offre a été bien supprimer"
        );

        $response = new Response(json_encode(array(
            'ok' => "ok"
        )));
        $response->headers->set('Content-Type', 'application/json');

        return $response;

    }

    public function modMesOffresAction(Request $request){

        $em = $this->getDoctrine()->getEntityManager();
        $offre= $em->find('AppBundle:Offre', $request->request->get('id'));


        $offre->setPoste($request->request->get('poste'));
        $offre->setLieux($request->request->get('lieux'));
        $offre->setType($request->request->get('type'));
        $offre->setSociete($request->request->get('societe'));
        $offre->setProfil($request->request->get('profil'));
        $offre->setMission($request->request->get('mission'));
        $dateSortie=new \DateTime($request->request->get('datedeb'));
        $dateSortie->format('dd-mm-YYYY');
        $offre->setDateDeb($dateSortie);

        $em->flush();


        $response = new Response(json_encode(array(
            'ok' => "ok"
        )));
        $response->headers->set('Content-Type', 'application/json');

        return $response;


    }

    public function ajouterOffreAction(Request $request){

        $em = $this->getDoctrine()->getEntityManager();

        $offre = new Offre();
        $offre->setUtilisateur($this->getUser());
        $dateSortie=new \DateTime($request->request->get('datedeb'));
        $dateSortie->format('dd-mm-YYYY');
        $offre->setDateDeb($dateSortie);
        $offre->setPoste($request->request->get('poste'));
        $dateExpr=new \DateTime($request->request->get('dateexpr'));
        $dateExpr->format('dd-mm-YYYY');
        $offre->setDateExpiration($dateExpr);
        $offre->setDatePublication(new \DateTime('now'));
        $offre->setLieux($request->request->get('lieux'));
        $offre->setMission($request->request->get('mission'));
        $offre->setNbvue(0);
        $offre->setSignale(0);
        $offre->setSociete($request->request->get('societe'));
        $offre->setProfil($request->request->get('profil'));
        $offre->setType($request->request->get('type'));

        $em->persist($offre);

        $em->flush();

        $listeuserRepository = $em->getRepository('AppBundle:User');
        $user = $listeuserRepository->findBy(array('cliqueOffre' => 1));


        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->SMTPDebug = 2;                                       // Enable verbose debug output
            $mail->isSMTP();                                            // Set mailer to use SMTP
            $mail->Host       = 'smtp.outlook.com;smtp.hotmail.com;smpt.gmail.com';  // Specify main and backup SMTP servers
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username   = 'privrisk.iriaf@outlook.fr';                     // SMTP username
            $mail->Password   = 'PrivRiskIriaf2019';                               // SMTP password
            $mail->SMTPSecure = 'tls';                                  // Enable TLS encryption, `ssl` also accepted
            $mail->Port       = 587;                                    // TCP port to connect to

            //Recipients
            $mail->setFrom('privrisk.iriaf@outlook.fr', 'Mailer');
            // Add a recipient
            for ($i=0;$i<sizeof($user);$i++) {
                $mail->addAddress($user[$i]->getEmail());               // Name is optional
            }              // Name is optional



            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'PrivRisk: nouveau offre ';
            $mail->Body    = " Bonjour Monsieur <br>
                           \Priv'Risk vient de publier un nouveau offre , veuillez vous connectez sur votre compte pour avoir plus de details. Merci !  <br>
                           ne repondez pas sur cet email ." ;
            //$mail->Body = preg_replace( array_keys( $replacements ), array_values( $replacements ), $email );
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();
            echo 'Message has been sent';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }

        $response = new Response(json_encode(array(
            'ok' => "ok",
            'id'=>$offre->getId()
        )));
        $response->headers->set('Content-Type', 'application/json');

        return $response;

    }

    public function mesactualliteAction(){

        $em = $this->getDoctrine()->getEntityManager();
        $listePanierRepository = $em->getRepository('AppBundle:Annonce');
        $liste = $listePanierRepository->findBy(array('utilisateur' =>$this->getUser() ));
        $MesActu=null;
        for($i=0;$i<sizeof($liste);$i++){
            $MesActu[$i]=$liste[$i];
        }



        return $this->render('users/mesActualite.html.twig' ,['annonces' => $MesActu]);
    }

    public function supprimerActualiteAction(Request $request){
        $em = $this->getDoctrine()->getEntityManager();
        $annonce= $em->find('AppBundle:Annonce', $request->request->get('id'));

        $em->remove($annonce);

        $em->flush();



        $response = new Response(json_encode(array(
            'ok' => "ok"
        )));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    public function modifierActualiteAction(Request $request){

        $em = $this->getDoctrine()->getEntityManager();
        $offre= $em->find('AppBundle:Annonce', $request->request->get('id'));


        $offre->setTitre($request->request->get('titre'));
        $offre->setAnnonce($request->request->get('annonce'));

        $em->flush();


        $response = new Response(json_encode(array(
            'ok' => "ok"
        )));
        $response->headers->set('Content-Type', 'application/json');

        return $response;

    }

    public function ajouterActualiteAction(Request$request){

        $em = $this->getDoctrine()->getEntityManager();
        $curentid=$this->getUser()->getId();
        $annonce = new Annonce();
        $file = $request->files->get ( 'image' );


        $annonce->setTitre($request->request->get('titre'));
        $annonce->setAnnonce($request->request->get('annonce'));
        $dateExpr=new \DateTime($request->request->get('dateExpr'));
        $dateExpr->format('dd-mm-YYYY');
        $annonce->setDateExpiration($dateExpr);
        $annonce->setDatePub(new \DateTime('now'));
        $annonce->setUtilisateur($this->getUser());



        $em->persist($annonce);

        $em->flush();



        $fileName = 'annonce'.$annonce->getId() . '.' . 'jpg';
        $img = Image::make($request->files->get ( 'image' )->getRealPath());

        // resize image instance
        $img->resize(600, 600);

        // save image in desired format
        $img->save($request->files->get ( 'image' )->getRealPath());


        $file->move ( $this->container->getParameter ( 'file_directory2' ), $fileName );

        $listeuserRepository = $em->getRepository('AppBundle:User');
        $user = $listeuserRepository->findBy(array('cliqueActualite' => 1));


        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->SMTPDebug = 2;                                       // Enable verbose debug output
            $mail->isSMTP();                                            // Set mailer to use SMTP
            $mail->Host       = 'smtp.outlook.com;smtp.hotmail.com;smpt.gmail.com';  // Specify main and backup SMTP servers
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username   = 'privrisk.iriaf@outlook.fr';                     // SMTP username
            $mail->Password   = 'PrivRiskIriaf2019';                               // SMTP password
            $mail->SMTPSecure = 'tls';                                  // Enable TLS encryption, `ssl` also accepted
            $mail->Port       = 587;                                    // TCP port to connect to

            //Recipients
            $mail->setFrom('privrisk.iriaf@outlook.fr', 'Mailer');
            // Add a recipient
            for ($i=0;$i<sizeof($user);$i++) {
                $mail->addAddress($user[$i]->getEmail());               // Name is optional
            }              // Name is optional



            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'PrivRisk: nouvelle actualité ';
            $mail->Body    = " Bonjour Monsieur <br>
                           \Priv'Risk vient de publier un nouvelle actualité , veuillez vous connectez sur votre compte pour avoir plus de details. Merci !  <br>
                           ne repondez pas sur cet email ." ;
            //$mail->Body = preg_replace( array_keys( $replacements ), array_values( $replacements ), $email );
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();
            echo 'Message has been sent';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }


        $response = new Response(json_encode(array(
            'ok' => "ok",
            'id'=>$annonce->getId()
        )));
        $response->headers->set('Content-Type', 'application/json');

        return $response;


    }

    public function profilAction(){

        $em = $this->getDoctrine()->getEntityManager();

        $listeproduitRepository = $em->getRepository('AppBundle:Nationalite');
        $nationalite = $listeproduitRepository->findAll();
        $i=0;
        $tableau=null;
        foreach ($nationalite as $natio ){
            $tableau[$i]=$natio->getNationalite();
            $i++;
        }
        $userRepository = $em->getRepository('AppBundle:User');
        $user = $userRepository->findOneBy(array('id' => $this->getUser()->getId()));

        $comRepository = $em->getRepository('AppBundle:Competence');
        $comps = $comRepository->findBy(array('utilisateur' => $this->getUser()->getId()));


        $natiotRepository = $em->getRepository('AppBundle:Nationalite');
        $comRepository = $em->getRepository('AppBundle:Mail');
        $mails = $comRepository->findBy(array('utilisateur' => $this->getUser()->getId()));


        $comRepository = $em->getRepository('AppBundle:Telephone');
        $tels = $comRepository->findBy(array('utilisateur' => $this->getUser()->getId()));


        $natioRepository = $em->getRepository('AppBundle:NationaliteUser');
        $natios = $natioRepository->findBy(array('utilisateur' => $this->getUser()->getId()));
        $tabNatio=null;
        for ($i=0;$i<sizeof($natios);$i++){

            $tabNatio[$i]=$natios[$i]->getNationalite();
        }




        $comRepository = $em->getRepository('AppBundle:Poste');
        $postes = $comRepository->findBy(array('utilisateur' => $this->getUser()->getId()));


        usort($postes, array($this, "orderByDate"));


        $etudiant=null;

        if($user->getEtudiant()==1){
            $etudiant='ok';

        }else{
            $etudiant='no';
        }


        $telEnv=$tels;
        if (empty($tels)){
            $telEnv = "vide";
        }
        $compsEnv=$comps;
        if (empty($comps)){
            $compsEnv="vide";
        }
        $mailsEnv=$mails;
        if (empty($mails)){
            $mailsEnv="vide";
        }
        if (empty($postes)){
            $postesEnv="vide";
        }else{
            $postesEnv=$postes[0];

        }
        $tabNatioEnv=$tabNatio;
        if ($tabNatio==null){
            $tabNatioEnv="vide";
        }


        $args = array('tab' => $postes ,'user' => $user  ,'tels'=>$telEnv,'comps'=>$compsEnv,'mails'=>$mailsEnv,'postes'=>$postesEnv, 'tab2'=>$tabNatioEnv,'etudiant'=>$etudiant , 'liste' => $tableau );

        return $this->render('users/MonProfil.html.twig',$args);
    }

    private function orderByDate($a, $b) {
        //retourner 0 en cas d'égalité
        if ($a->getDateFin() == $b->getDateFin()) {
            return 0;
        } else if ($a->getDateFin() > $b->getDateFin()) {//retourner -1 en cas d’infériorité
            return -1;
        } else {//retourner 1 en cas de supériorité
            return 1;
        }
    }

    public function completerProfilAction(Request $request){







        $em = $this->getDoctrine()->getEntityManager();
        $nationaliteRepository = $em->getRepository('AppBundle:Nationalite');
        $userRepository = $em->getRepository('AppBundle:User');
        $user = $userRepository->findOneBy(array('id' => $this->getUser()->getId()));

        $email='email';
        $telephone='telephone';
        $natio ='nationalite';
        $competence ='competence';
        $post='poste';
        $entre='entreprise';
        $dated='datedeb';
        $datef='datefin';

        for($i=2;$i<count($request->request)+2;$i++){

            $a=$email.$i;
            $b=$telephone.$i;
            $c=$natio.$i;
            $d=$competence.$i;
            $p=$post.$i;
            $e=$entre.$i;
            $dd=$dated.$i;
            $df=$datef.$i;

            if($request->request->get($a) != null){


                $em = $this->getDoctrine()->getEntityManager();
                $mail = new Mail();
                $mail->setMail($request->request->get($a));
                $mail->setUtilisateur($user);
                $em->persist($mail);
                $em->flush();
            }
            if($request->request->get($b) != null) {


                $em = $this->getDoctrine()->getEntityManager();
                $tel = new Telephone();
                $tel->setTelephone($request->request->get($b));
                $user->setTelephone($request->request->get($b));
                $tel->setUtilisateur($user);
                $em->persist($tel);
                $em->flush();
            }
            if($request->request->get($c) != null){


                $nationalite = $nationaliteRepository->findOneBy(array('nationalite' => $request->request->get($c)));
                $em = $this->getDoctrine()->getEntityManager();
                $nat = new NationaliteUser();
                $nat->setUtilisateur($user);
                $nat->setNationalite($nationalite);
                $em->persist($nat);
                $em->flush();
            }

            if($request->request->get($d) != null){

                $em = $this->getDoctrine()->getEntityManager();
                $comp = new Competence();
                $comp->setCompetence($request->request->get($d));
                $comp->setUtilisateur($user);
                $em->persist($comp);
                $em->flush();
            }

            if($request->request->get($p) != null && $request->request->get($e)!=null && $request->request->get($dd) != null && $request->request->get($df)!=null){


                $em = $this->getDoctrine()->getEntityManager();
                $poste= new Poste();
                $poste->setUtilisateur($user);
                $poste->setPoste($request->request->get($p));
                $poste->setEntreprise($request->request->get($e));
                $datedebut = new \DateTime($request->request->get($dd));
                $datedebut->format('YYYY-mm-dd');
                $datefin = new \DateTime($request->request->get($df));
                $datefin->format('YYYY-mm-dd');
                $poste->setDateDeb($datedebut);
                $poste->setDateFin($datefin);
                $em->persist($poste);
                $em->flush();

            }



        }




        $listeproduitRepository = $em->getRepository('AppBundle:Nationalite');
        $nationalite = $listeproduitRepository->findAll();
        $i=0;
        $tableau=null;
        foreach ($nationalite as $natio ){
            $tableau[$i]=$natio->getNationalite();
            $i++;
        }


        $comRepository = $em->getRepository('AppBundle:Competence');
        $comps = $comRepository->findBy(array('utilisateur' => $this->getUser()->getId()));


        $natiotRepository = $em->getRepository('AppBundle:Nationalite');
        $comRepository = $em->getRepository('AppBundle:Mail');
        $mails = $comRepository->findBy(array('utilisateur' => $this->getUser()->getId()));


        $comRepository = $em->getRepository('AppBundle:Telephone');
        $tels = $comRepository->findBy(array('utilisateur' => $this->getUser()->getId()));


        $natioRepository = $em->getRepository('AppBundle:NationaliteUser');
        $natioRepository2 = $em->getRepository('AppBundle:Nationalite');
        $natios = $natioRepository->findBy(array('utilisateur' => $this->getUser()->getId()));
        $tabNatio=null;
        for ($i=0;$i<sizeof($natios);$i++){

            $tabNatio[$i]=$natios[$i]->getNationalite();

        }


        $comRepository = $em->getRepository('AppBundle:Poste');
        $postes = $comRepository->findBy(array('utilisateur' => $this->getUser()->getId()));


        usort($postes, array($this, "orderByDate"));


        $etudiant=null;

        if($user->getEtudiant()==1){
            $etudiant='ok';

        }else{
            $etudiant='no';
        }


        $telEnv=$tels;
        if (empty($tels)){
            $telEnv = "vide";
        }
        $compsEnv=$comps;
        if (empty($comps)){
            $compsEnv="vide";
        }
        $mailsEnv=$mails;
        if (empty($mails)){
            $mailsEnv="vide";
        }
        if (empty($postes)){
            $postesEnv="vide";
        }else{
            $postesEnv=$postes[0];

        }
        $tabNatioEnv=$tabNatio;
        if ($tabNatio==null){
            $tabNatioEnv="vide";
        }


        $curentid=$this->getUser()->getId();
        $file = $request->files->get ( 'photo' );

        if ($file != null){
            $fileName = 'img'.$curentid . '.' . 'jpeg';
            $img = Image::make($request->files->get ( 'photo' )->getRealPath());

            // resize image instance
            $img->resize(300, 300);

            // save image in desired format
            $img->save($request->files->get ( 'photo' )->getRealPath());


            $file->move ( $this->container->getParameter ( 'file_directory' ), $fileName );

        }


        $args = array('tab' => $postes ,'user' => $user  ,'tels'=>$telEnv,'comps'=>$compsEnv,'mails'=>$mailsEnv,'postes'=>$postesEnv,'tab2'=>$tabNatioEnv,'etudiant'=>$etudiant , 'liste' => $tableau);

        return $this->render('users/MonProfil.html.twig',$args);

    }

    public function suppCompAction(Request $request){

        $em = $this->getDoctrine()->getEntityManager();
        $competence= $em->find('AppBundle:Competence', $request->request->get('id'));

        $em->remove($competence);

        $em->flush();



        $response = new Response(json_encode(array(
            'ok' => "ok"
        )));
        $response->headers->set('Content-Type', 'application/json');

        return $response;

    }

    public function modCompAction(Request $request){
        $em = $this->getDoctrine()->getEntityManager();
        $listePanierRepository = $em->getRepository('AppBundle:Competence');
        $liste = $listePanierRepository->findOneBy(array('id' => $request->request->get('id') , 'utilisateur' =>$this->getUser()));

        $liste->setCompetence($request->request->get('competence'));
        $em->flush();

        $response = new Response(json_encode(array(
            'ok' => "ok"
        )));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    public function suppTelAction(Request $request){
        $em = $this->getDoctrine()->getEntityManager();
        $competence= $em->find('AppBundle:Telephone', $request->request->get('id'));

        $em->remove($competence);

        $em->flush();



        $response = new Response(json_encode(array(
            'ok' => "ok"
        )));
        $response->headers->set('Content-Type', 'application/json');

        return $response;

    }

    public function modTelAction(Request $request){
        $em = $this->getDoctrine()->getEntityManager();
        $listePanierRepository = $em->getRepository('AppBundle:Telephone');
        $liste = $listePanierRepository->findOneBy(array('id' => $request->request->get('id') , 'utilisateur' =>$this->getUser()));

        $liste->setTelephone($request->request->get('telephone'));
        $em->flush();

        $response = new Response(json_encode(array(
            'ok' => "ok"
        )));
        $response->headers->set('Content-Type', 'application/json');

        return $response;

    }

    public function suppMailAction(Request $request){
        $em = $this->getDoctrine()->getEntityManager();
        $competence= $em->find('AppBundle:Mail', $request->request->get('id'));

        $em->remove($competence);

        $em->flush();



        $response = new Response(json_encode(array(
            'ok' => "ok"
        )));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    public function modMailAction(Request $request){

        $em = $this->getDoctrine()->getEntityManager();
        $listePanierRepository = $em->getRepository('AppBundle:Mail');
        $liste = $listePanierRepository->findOneBy(array('id' => $request->request->get('id') , 'utilisateur' =>$this->getUser()));

        $liste->setMail($request->request->get('mail'));
        $em->flush();

        $response = new Response(json_encode(array(
            'ok' => "ok"
        )));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    public function suppPosteAction(Request $request){
        $em = $this->getDoctrine()->getEntityManager();
        $competence= $em->find('AppBundle:Poste', $request->request->get('id'));

        $em->remove($competence);

        $em->flush();



        $response = new Response(json_encode(array(
            'ok' => "ok"
        )));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    public function modPosteAction(Request $request){
        $em = $this->getDoctrine()->getEntityManager();
        $listePanierRepository = $em->getRepository('AppBundle:Poste');
        $liste = $listePanierRepository->findOneBy(array('id' => $request->request->get('id') , 'utilisateur' =>$this->getUser()));

        $liste->setEntreprise($request->request->get('entreprise'));
        $liste->setPoste($request->request->get('poste'));
        $dateExpr=new \DateTime($request->request->get('datedeb'));
        $dateExpr->format('dd-mm-YYYY');
        $liste->setDateDeb($dateExpr);
        $dateExpr=new \DateTime($request->request->get('datefin'));
        $dateExpr->format('dd-mm-YYYY');
        $liste->setDateFin($dateExpr);
        $em->flush();

        $response = new Response(json_encode(array(
            'ok' => "ok"
        )));
        $response->headers->set('Content-Type', 'application/json');

        return $response;

    }
    public function envoieAction(Request $request){



        $user = $this->getUser();

        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->SMTPDebug = 2;                                       // Enable verbose debug output
            $mail->isSMTP();                                            // Set mailer to use SMTP
            $mail->Host       = 'smtp.outlook.com;smtp.hotmail.com;smpt.gmail.com';  // Specify main and backup SMTP servers
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username   = 'privrisk.iriaf@outlook.fr';                     // SMTP username
            $mail->Password   = 'PrivRiskIriaf2019';                               // SMTP password
            $mail->SMTPSecure = 'tls';                                  // Enable TLS encryption, `ssl` also accepted
            $mail->Port       = 587;                                    // TCP port to connect to

            //Recipients
            $mail->setFrom('privrisk.iriaf@outlook.fr');
            // Add a recipient

            $mail->addAddress($request->request->get('mail'));               // Name is optional




            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'Priv Risk : Nouveau message ';
            $mail->Body    = 'Ce message a ete envoyé par monsieur / madame '.$user->getNom(). ' '. $user->getPrenom() .' <br> <br> message :  '. $request->request->get('message') ;
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();
            echo 'Message has been sent';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }


        $response = new Response(json_encode(array(
            'ok' => "ok"
        )));
        $response->headers->set('Content-Type', 'application/json');

        return $response;


    }

    public function modMdpAction(Request $request , UserPasswordEncoderInterface $encoder){

        $curentid=$this->getUser()->getId();
        $em = $this->getDoctrine()->getEntityManager();
        $userRepository = $em->getRepository('AppBundle:User');
        $user = $userRepository->findOneBy(array('id' => $curentid));
        $plainPassword = $request->request->get('mdp');
        $encoded = $encoder->encodePassword($user, $plainPassword);
        $user->setPassword($encoded);
        $em->flush();
        $response = new Response(json_encode(array(
            'ok' => "ok"
        )));
        $response->headers->set('Content-Type', 'application/json');

        return $response;


    }

    public function modNomAction(Request $request){


        $curentid=$this->getUser()->getId();
        $em = $this->getDoctrine()->getEntityManager();
        $userRepository = $em->getRepository('AppBundle:User');
        $user = $userRepository->findOneBy(array('id' => $curentid));
        $user->setNom($request->request->get('nom'));
        $em->flush();
        $response = new Response(json_encode(array(
            'ok' => "ok"
        )));
        $response->headers->set('Content-Type', 'application/json');

        return $response;



    }

    public function modPrenomAction(Request $request){


        $curentid=$this->getUser()->getId();
        $em = $this->getDoctrine()->getEntityManager();
        $userRepository = $em->getRepository('AppBundle:User');
        $user = $userRepository->findOneBy(array('id' => $curentid));
        $user->setPrenom($request->request->get('prenom'));
        $em->flush();
        $response = new Response(json_encode(array(
            'ok' => "ok"
        )));
        $response->headers->set('Content-Type', 'application/json');

        return $response;



    }
    public function modPseudoAction(Request $request){
        $curentid=$this->getUser()->getId();
        $em = $this->getDoctrine()->getEntityManager();
        $userRepository = $em->getRepository('AppBundle:User');
        $user = $userRepository->findOneBy(array('id' => $curentid));
        $user->setUsername($request->request->get('pseudo'));
        $user->setUsernameCanonical($request->request->get('pseudo'));
        $em->flush();
        $response = new Response(json_encode(array(
            'ok' => "ok"
        )));
        $response->headers->set('Content-Type', 'application/json');

        return $response;



    }

    public function rechercheOffreAction(Request $request){

        $em = $this->getDoctrine()->getEntityManager();
        $listeoffreRepository = $em->getRepository('AppBundle:Offre');



         if ($request->request->get('type') != "vide" and $request->request->get('ville')!="" and $request->request->get('metiers') != "" ){

             $RAW_QUERY1='select * from offre where offre.type = "'.$request->request->get('type').'" and offre.lieux = "'.$request->request->get('ville').'" and offre.poste= "'.$request->request->get('metiers').'" ;';

             $statement = $em->getConnection()->prepare($RAW_QUERY1);
             $statement->execute();

             $offres1 = $statement->fetchAll();

             $RAW_QUERY = 'SELECT * FROM offre WHERE CONCAT(mission, profil) LIKE "%'.$request->request->get('metiers').'%";';

             $statement = $em->getConnection()->prepare($RAW_QUERY);
             $statement->execute();

             $offres2 = $statement->fetchAll();


             $offres=array_merge($offres1,$offres2);

             $paginator = $this->get('knp_paginator');


             $result=$paginator->paginate(
                 $offres ,
                 $request->query->getInt('page',1),
                 $request->query->getInt('limit',3)
             );

         }elseif($request->request->get('type') != "vide" and $request->request->get('ville')!=""){
             $RAW_QUERY1='select * from offre where offre.type = "'.$request->request->get('type').'" and offre.lieux = "'.$request->request->get('ville').'" ;';

             $statement = $em->getConnection()->prepare($RAW_QUERY1);
             $statement->execute();

             $offres = $statement->fetchAll();

             $paginator = $this->get('knp_paginator');


             $result=$paginator->paginate(
                 $offres ,
                 $request->query->getInt('page',1),
                 $request->query->getInt('limit',3)
             );

         }elseif ($request->request->get('type') != "vide"){
             $RAW_QUERY1='select * from offre where offre.type = "'.$request->request->get('type').'" ;';

             $statement = $em->getConnection()->prepare($RAW_QUERY1);
             $statement->execute();

             $offres = $statement->fetchAll();


             $paginator = $this->get('knp_paginator');


             $result=$paginator->paginate(
                 $offres ,
                 $request->query->getInt('page',1),
                 $request->query->getInt('limit',3)
             );
         }elseif ($request->request->get('ville')!=""){
             $RAW_QUERY1='select * from offre where offre.lieux = "'. $request->request->get('ville') .'" ;';

             $statement = $em->getConnection()->prepare($RAW_QUERY1);
             $statement->execute();

             $offres = $statement->fetchAll();
             $paginator = $this->get('knp_paginator');


             $result=$paginator->paginate(
                 $offres ,
                 $request->query->getInt('page',1),
                 $request->query->getInt('limit',3)
             );
         }elseif ($request->request->get('metiers') != ""){
             $RAW_QUERY1='select * from offre where offre.poste= "'.$request->request->get('metiers').'" ;';

             $statement = $em->getConnection()->prepare($RAW_QUERY1);
             $statement->execute();

             $offres1 = $statement->fetchAll();

             $RAW_QUERY = 'SELECT * FROM offre WHERE CONCAT(mission, profil) LIKE "%'.$request->request->get('metiers').'%";';

             $statement = $em->getConnection()->prepare($RAW_QUERY);
             $statement->execute();

             $offres2 = $statement->fetchAll();




             $offres=array_merge($offres1,$offres2);

             $paginator = $this->get('knp_paginator');


             $result=$paginator->paginate(
                 $offres ,
                 $request->query->getInt('page',1),
                 $request->query->getInt('limit',3)
             );
         }


         if (empty($offres)){
            $result="vide";
         }


        return $this->render('users/offres.html.twig',['offres' => $result]);


    }

    public function securitéAction(){

        return $this->render('users/securite.html.twig');
    }

    public function utilisationAction(){
        return $this->render('users/utilisation.html.twig');
    }

    public function recherchePersonneAction(Request $request){

        $tab =explode(' ' ,$request->request->get('personne'));

        $em = $this->getDoctrine()->getEntityManager();

        $listeproduitRepository = $em->getRepository('AppBundle:User');
        $users = $listeproduitRepository->findAll();
        $user=[];
        $j=0;
        for ($i=0;$i<sizeof($users);$i++){



            if (strcasecmp ($users[$i]->getNom(),$tab[0]) == 0 && strcasecmp ($users[$i]->getPrenom(),$tab[1])==0 ){

                $user[$j]=$users[$i];
                $j++;
            }
        }

        $listeproduitRepository = $em->getRepository('AppBundle:Telephone');
        $telephones = $listeproduitRepository->findBy(array('utilisateur' => $request->request->get('id')));




        return $this->render('users/rechrche.html.twig' , ['users' => $user]);

    }

}