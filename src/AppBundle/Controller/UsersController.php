<?php

namespace AppBundle\Controller;


use AppBundle\Entity\Nationalite;
use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Intervention\Image\ImageManagerStatic as Image;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UsersController extends Controller
{
    public function clientAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $listeoffreRepository = $em->getRepository('AppBundle:Offre');
        $offres = $listeoffreRepository->findAll();

        $listeannonceRepository = $em->getRepository('AppBundle:Annonce');
        $annonces = $listeannonceRepository->findAll();


        usort($offres, array($this, "orderByDate"));
        $tab=null;

        if(sizeof($offres)==1){
            $tab[0]=$offres[0];
        }elseif (sizeof($offres)==2){
            $tab[0]=$offres[0];
            $tab[1]=$offres[1];

        }elseif (sizeof($offres)>=3){
            $tab[0]=$offres[0];
            $tab[1]=$offres[1];
            $tab[2]=$offres[2];
        }


        usort($annonces, array($this, "orderByDate2"));
        $tab1=null;

        if(sizeof($annonces)==1){
            $tab1[0]=$annonces[0];
        }elseif (sizeof($annonces)==2){
            $tab1[0]=$annonces[0];
            $tab1[1]=$annonces[1];

        }elseif (sizeof($annonces)>=3){
            $tab1[0]=$annonces[0];
            $tab1[1]=$annonces[1];
            $tab1[2]=$annonces[2];
        }



        return $this->render('users/client.html.twig',['offres' => $tab , 'annonces'=>$tab1]);
    }

    private function orderByDate($a, $b) {
            //retourner 0 en cas d'égalité
        if ($a->getdatePublication() == $b->getdatePublication()) {
        return 0;
        } else if ($a->getdatePublication() > $b->getdatePublication()) {//retourner -1 en cas d’infériorité
            return -1;
        } else {//retourner 1 en cas de supériorité
            return 1;
        }
    }

    private function orderByDate2($a, $b) {
        //retourner 0 en cas d'égalité
        if ($a->getDatePub() == $b->getDatePub()) {
            return 0;
        } else if ($a->getDatePub() > $b->getDatePub()) {//retourner -1 en cas d’infériorité
            return -1;
        } else {//retourner 1 en cas de supériorité
            return 1;
        }
    }


    public function adminAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $listeoffreRepository = $em->getRepository('AppBundle:User');
        $users = $listeoffreRepository->findAll();
            $nb=0;
          for ($i=0;$i<sizeof($users);$i++){
              if ($users[$i]->getRoles()[0]=="ROLE_USER"){
                  $nb++;
              }
          }

        $nationaliteRepository = $em->getRepository('AppBundle:Nbvue');

        $nbvue=$nationaliteRepository->findOneBy(array('id' => 1));
        $em->flush();
        return $this->render('adminviews/index.html.twig',['nb' => $nb , 'nbvue'=>$nbvue->getNbvue()]);
    }

    public function successAction()
    {
        return $this->render('users/login_success.html.twig');
    }

    public function moderateurAction()
    {

       /*$tableau = array("Afghanistan",
"Afrique du Sud",
"Albanie",
"Algérie",
"Allemagne",
"Andorre",
"Angola",
"Arabie Saoudite",
"Argentine",
"Arménie",
"Aruba",
"Australie",
"Autriche",
"Azerbaïdjan", "Bahreïn",
"Le Bangladesh",
"La Barbade",
"La Biélorussie / Le Bélarus",
"La Birmanie",
"La Belgique",
"Le Belize",
"Le Bénin",
"Les Bermudes",
"Le Bhoutan",
"La Bolivie",
"La Bosnie-Herzégovine",
"Le Botswana",
"Le Brésil",
"Le Brunéi",
"La Bulgarie",
"Le Burkina Faso",
"Le Burundi",
"Le Cameroun",
"Le Canada",
"Le Cap-Vert",
"La Rép. centrafricaine",
"Le Chili",
"La Chine",
          " Chypre",
           "La Colombie ",
           "Les Comores ",
           "La Rép. du Congo ",
           "La Rép. dém. du Congo ",
           "La Corée du Nord ",
           "Le Costa Rica ",
           "La Côte d’Ivoire ",
           "La Croatie ",
           "Cuba ",
           "Le Danemark ",
           "Djibouti ",
           "La Dominique ",
           "L'Égypte ",
           "Les Émirats arabes unis ",
           "L'Équateur ",
           "LÉrythrée ",
           "L'Espagne ",
           "L'Estonie ",
           "Les États-Unis ",
           "L'Éthiopie ",
           "Les Fidji ",
           "La Finlande ",
           "La France ",
           "Le Gabon ",
           "La Gambie ",
           "La Géorgie ",
           "Le Ghana ",
           "Gibraltar ",
           "La Grèce ",
           "Grenade ",
           "Le Guatemala ",
           "La Guinée ",
           "La Guinée-Bissau ",
           "La Guinée équatoriale ",
           "Le Guyana ",
           "Haïti ",
           "Le Honduras ",
           "La Hongrie ",
           "L'Inde ",
           "L'Indonésie ",
           "L'Iran ",
           "L'Irak ",
           "L'Irlande ",
           "L'Islande ",
           "Israël ",
           "L'Italie ",
           "La Jamaïque ",
           "Le Japon ",
           "La Jordanie ",
           "Le Kazakhstan ",
           "Le Kenya ",
           "Le Kirghizistan ",
           "Les Kiribati ",
           "Le Koweït ",
           "Le Kosovo ",
           "Le Laos ",
           "Le Lesotho ",
           "La Lettonie ",
           "Le Liban ",
           "Le Libéria ",
           "La Libye ",
           "Le Liechtenstein ",
           "La Lituanie ",
           "Le Luxembourg ",
           "La Macédoine ",
           "Madagascar ",
           "La Malaisie ",
           "Le Malawi ",
           "Les Maldives ",
           "Le Mali ",
           "Malte ",
           "Le Maroc ",
           "Maurice ",
           "La Mauritanie ",
           "Le Mexique ",
           "Monaco ",
           "La Mongolie ",
           "Le Monténégro ",
           "Le Mozambique ",
           "La Namibie ",
           "Le Népal ",
           "Le Nicaragua ",
           "Le Niger ",
           "Le Nigéria ",
           "La Norvège ",
           "La Nouvelle-Zélande ",
           "Oman ",
           "L'Ouganda ",
           "L'Ouzbékistan ",
           "Le Pakistan ",
           "Le Panama ",
           "LaPapouasie-Nouvelle-Guinée ",
           "Le Paraguay ",
           "Les Pays-Bas ",
           "Le Pérou ",
           "Les Philippines ",
           "La Pologne ",
           "Porto Rico ",
           "Le Portugal ",
           "Le Qatar ",
           "La République dominicaine ",
           "La République tchèque ",
"La Roumanie",
"Le Royaume-Uni",
           "La Russie",
           "Le Rwanda",
           "St-Vincent-et-les-Grenadines",
           "Le Salvador",
           "Le Sénégal",
           "La Serbie",
           "Le Sierra Leone",
           "Singapour",
           "La Slovaquie",
           "La Slovénie",
           "La Somalie",
           "Le Soudan",
           "Le Sri Lanka",
           "La Suède",
           "La Suisse",
           "Le Surinam",
           "Le Swaziland",
           "La Syrie",
           "Le Tadjikistan",
           "Taïwan",
           "La Tanzanie",
           "Le Tchad",
           "LaThaïlande",
 "Le Timor-Oriental ",
 "Le Togo ",
 "La Tunisie ",
 "Le Turkménistan ",
 "La Turquie ",
 "Les Tuvalu ",
 "L'Ukraine ",
 "L'Uruguay ",
 "Le Vatican ",
 "Le Venezuela ",
 "Le Vietnam ",
 "Le Yémen ",
 "La Zambie ",
 "Le Zimbabwe ");*/



        $em = $this->getDoctrine()->getEntityManager();
        $userRepository = $em->getRepository('AppBundle:User');
        $user = $userRepository->findOneBy(array('id' => $this->getUser()->getId()));

        /*for ($i=0;$i<sizeof($tableau);$i++){
            $natio = new Nationalite();
            $natio->setNationalite($tableau[$i]);
            $em->persist($natio);
            $em->flush();
        }*/

        $tableau[0]=$user->getNom();
        $tableau[1]=$user->getPrenom();
        $tableau[2]=$user->getUsername();
        $tableau[3]=$user->getEmail();
        $tableau[4]=$user->getPassword();
        $args = array('user' => $user , 'tableauinfo'=>$tableau);

        return $this->render('moderateur/indexMod.html.twig',$args);
    }

    public function adminAdmissionAction(){


        $em = $this->getDoctrine()->getEntityManager();
        $UtilisateurRepository = $em->getRepository('AppBundle:User');
        $utilisateur = $UtilisateurRepository->findBy(array('etat' => false));

        $args = array('users' => $utilisateur );
        return $this->render('adminviews/demandes.html.twig',$args);
    }

    public function modAdmissionAction(){
        $em = $this->getDoctrine()->getEntityManager();
        $UtilisateurRepository = $em->getRepository('AppBundle:User');
        $utilisateur = $UtilisateurRepository->findBy(array('etat' => false));

        $args = array('users' => $utilisateur );
        return $this->render('moderateur/demandes.html.twig',$args);
    }

    public function accepterUserAction(Request $request){



        $em = $this->getDoctrine()->getEntityManager();

        $utilisateur = $em->find('AppBundle:User', $request->request->get('iduser'));

        $utilisateur->setEtat(true);
        $em->flush();

        $this->addFlash(
            'token',
            "Opération d'acceptation a été fait avec succes"
        );

        return $this->redirectToRoute('demande_addmission');

    }

    public function modaccepterUserAction(Request $request){
        $em = $this->getDoctrine()->getEntityManager();

        $utilisateur = $em->find('AppBundle:User', $request->request->get('iduser'));

        $utilisateur->setEtat(true);
        $em->flush();

        $this->addFlash(
            'token',
            "Opération d'acceptation a été fait avec succes"
        );

        return $this->redirectToRoute('demande_addmission_mod');

    }

    public function refuserUserAction(Request $request){

        $em = $this->getDoctrine()->getEntityManager();
        $utilisateur = $em->find('AppBundle:User', $request->request->get('iduser'));

        $em->remove($utilisateur);

        $em->flush();

        $this->addFlash(
            'token',
            "Opération de refus a été fait avec succes"
        );

        return $this->redirectToRoute('demande_addmission');

    }
    public function modrefuserUserAction(Request $request){
        $em = $this->getDoctrine()->getEntityManager();
        $utilisateur = $em->find('AppBundle:User', $request->request->get('iduser'));

        $em->remove($utilisateur);

        $em->flush();

        $this->addFlash(
            'token',
            "Opération de refus a été fait avec succes"
        );

        return $this->redirectToRoute('demande_addmission_mod');

    }

    public function gererUserAction(){

        $em = $this->getDoctrine()->getEntityManager();
        $UtilisateurRepository = $em->getRepository('AppBundle:User');
        $utilisateur = $UtilisateurRepository->findBy(array('etat' => true));



        $args = array('users' => $utilisateur );

        return $this->render('adminviews/gereruser.html.twig',$args);

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


    public function suppUserAction(Request $request){

        $em = $this->getDoctrine()->getEntityManager();
        $utilisateur = $em->find('AppBundle:User', $request->request->get('iduser'));

        $em->remove($utilisateur);

        $em->flush();

        $this->addFlash(
            'token',
            "Opération de suppression a été fait avec succes"
        );

        if($request->request->get('redirection')=="suppMembre"){

            return $this->redirectToRoute('admin_gerer_utilisateur');
        }elseif($request->request->get('redirection')=="suppAdmin"){
            return $this->redirectToRoute('admin_gerer_admins');
        }elseif($request->request->get('redirection')=="suppModerateur"){
            return $this->redirectToRoute('admin_gerer_moderateur');
        }


    }

    public function gererAdminsAction(){

        $em = $this->getDoctrine()->getEntityManager();
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

        $args = array('users' => $userEnvoyer );

        return $this->render('adminviews/gererAdmins.html.twig',$args);


    }

    public function ajouterAdminsAction(Request $request , UserPasswordEncoderInterface $encoder){

       if($request->request->get('annuler')== "annuler" ){
           if($request->request->get('redirection')=="ajoutAdmin")
             return $this->redirectToRoute('admin_gerer_admins');
           else
               return $this->redirectToRoute('admin_gerer_moderateur');

       }elseif($request->request->get('buttonAjouter')== "ajouter"){

           $em = $this->getDoctrine()->getEntityManager();

           $listeuserRepository = $em->getRepository('AppBundle:User');
           $user = $listeuserRepository->findAll();

           foreach ($user as $u){

               if ($u->getUsername()==$request->request->get('pseudo') ) {
                   $this->addFlash(
                       'ajoutErreur',
                       "Opération d'ajout a été échoué !! pseudo existe déja . "
                   );

                   if($request->request->get('redirection')=="ajoutAdmin")
                       return $this->redirectToRoute('admin_gerer_admins');
                   elseif($request->request->get('redirection')=="ajoutModerateur")

                       return $this->redirectToRoute('admin_gerer_moderateur');


               } elseif ($u->getEmail()==$request->request->get('email')){

                   $this->addFlash(
                       'ajoutErreur',
                       "Opération d'ajout a été échoué !! email existe déja . "
                   );

                   if($request->request->get('redirection')=="ajoutAdmin")
                       return $this->redirectToRoute('admin_gerer_admins');
                   elseif($request->request->get('redirection')=="ajoutModerateur")
                       return $this->redirectToRoute('admin_gerer_moderateur');

               }

           }




           $user = new User();

           $plainPassword = $request->request->get('mdp');
           $encoded = $encoder->encodePassword($user, $plainPassword);


           $user->setNom($request->request->get('nom'));
           $user->setPrenom($request->request->get('prenom'));
           $user->setEmail($request->request->get('email'));
           $user->setUsername($request->request->get('pseudo'));
           $user->setEmailCanonical($request->request->get('email'));
           $user->setUsernameCanonical($request->request->get('pseudo'));
           $user->setPassword($encoded);
           $user->setEnabled(true);
           $user->setEtat(true);

           if($request->request->get('redirection')=="ajoutAdmin")
              $user->setRoles(array('ROLE_ADMIN'));
           else
               $user->setRoles(array('ROLE_MODERATEUR'));

           $em->persist($user);

           $em->flush();

           $this->addFlash(
               'ajoutsucces',
               "Opération d'ajout a été fait avec succes"
           );


           if($request->request->get('redirection')=="ajoutAdmin")
              return $this->redirectToRoute('admin_gerer_admins');
           else
               return $this->redirectToRoute('admin_gerer_moderateur');


       }

        return $this->render('adminviews/gererAdmins.html.twig');


    }

    public function gerermoderateurAction(){

        $em = $this->getDoctrine()->getEntityManager();
        $listeuserRepository = $em->getRepository('AppBundle:User');
        $user = $listeuserRepository->findAll();
        $userEnvoyer=null;
        $i=0;
        foreach ($user as $u){

            if($this->userHasRole($u->getId(),"ROLE_MODERATEUR")==true){
                $userEnvoyer[$i]=$u;
                $i++;
            }
        }

        $args = array('users' => $userEnvoyer );

        return $this->render('adminviews/gererModerateur.html.twig',$args);

    }

    public function profilAdminAction(){


        $em = $this->getDoctrine()->getEntityManager();
        $userRepository = $em->getRepository('AppBundle:User');
        $user = $userRepository->findOneBy(array('id' => $this->getUser()->getId()));


        $tableau[0]=$user->getNom();
        $tableau[1]=$user->getPrenom();
        $tableau[2]=$user->getUsername();
        $tableau[3]=$user->getEmail();
        $tableau[4]=$user->getPassword();
        $args = array('user' => $user , 'tableauinfo'=>$tableau);


        return $this->render('adminviews/profile.html.twig',$args);

    }

    public function modifierAdminAction(Request $request , UserPasswordEncoderInterface $encoder ){

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


        if($request->request->get('annuler')== "annuler" ){
                return $this->redirectToRoute('admin_gerer_admins');

        }elseif($request->request->get('buttonModifier')== "modifier"){


            $em = $this->getDoctrine()->getEntityManager();
            $userRepository = $em->getRepository('AppBundle:User');
            $user = $userRepository->findOneBy(array('id' => $curentid));


            $plainPassword = $request->request->get('mdp');
            $encoded = $encoder->encodePassword($user, $plainPassword);


            $user->setNom($request->request->get('nom'));
            $user->setPrenom($request->request->get('prenom'));
            $user->setEmail($request->request->get('email'));
            $user->setUsername($request->request->get('pseudo'));
            $user->setPassword($encoded);
            $user->setUsernameCanonical($request->request->get('pseudo'));
            $user->setEtat(true);
            $user->setEnabled(true);

            $em->flush();

        }

        $this->addFlash(
            'modifsucces',
            "Opération de modification de profil a été fait avec succes"
        );



        return $this->redirectToRoute('profil');


    }

    public function gererOffreAction(){
        $em = $this->getDoctrine()->getEntityManager();
        $userRepository = $em->getRepository('AppBundle:Offre');
        $offre = $userRepository->findBy(array('signale' => 1));

        $args = array('offres' => $offre );

        return $this->render('adminviews/gereroffre.html.twig',$args);
    }

    public function modifierModAction(Request $request , UserPasswordEncoderInterface $encoder){

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


        if($request->request->get('annuler')== "annuler" ){
            return $this->redirectToRoute('moderateur_page');

        }elseif($request->request->get('buttonModifier')== "modifier"){


            $em = $this->getDoctrine()->getEntityManager();
            $userRepository = $em->getRepository('AppBundle:User');
            $user = $userRepository->findOneBy(array('id' => $curentid));


            $plainPassword = $request->request->get('mdp');
            $encoded = $encoder->encodePassword($user, $plainPassword);


            $user->setNom($request->request->get('nom'));
            $user->setPrenom($request->request->get('prenom'));
            $user->setEmail($request->request->get('email'));
            $user->setUsername($request->request->get('pseudo'));
            $user->setPassword($encoded);
            $user->setUsernameCanonical($request->request->get('pseudo'));
            $user->setEtat(true);
            $user->setEnabled(true);

            $em->flush();

        }

        $this->addFlash(
            'modifsucces',
            "Opération de modification de profil a été fait avec succes"
        );



        return $this->redirectToRoute('moderateur_page');
    }




}
