<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Competence;
use AppBundle\Entity\Mail;
use AppBundle\Entity\Nationalite;
use AppBundle\Entity\NationaliteUser;
use AppBundle\Entity\Poste;
use AppBundle\Entity\Telephone;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//require 'vendor/autoload.php';

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }

    public function forbiddenAction()
    {
        $this->addFlash(
            'token',
            'Vous avez pas le droit dacceder au profil demandé'
        );

        return $this->redirectToRoute('login_ok');
    }

    public function register2Action($username){



        $em = $this->getDoctrine()->getEntityManager();
        $listeproduitRepository = $em->getRepository('AppBundle:Nationalite');
        $nationalite = $listeproduitRepository->findAll();
         $i=0;
         $tableau=null;
        foreach ($nationalite as $natio ){
          $tableau[$i]=$natio->getNationalite();
          $i++;
        }

        $args = array('liste' => $tableau ,'username'=>$username);

        return $this->render('default/enregister.html.twig' , $args);
    }

    public function registerAction(Request $request , \Swift_Mailer $mailer){

        $tableau1 =$request->request->get('accept1');
        $tableau2=$request->request->get('accept2');
        $em = $this->getDoctrine()->getEntityManager();
        $userRepository = $em->getRepository('AppBundle:User');
        $user = $userRepository->findOneBy(array('username' => $request->request->get('username')));

        $nationaliteRepository = $em->getRepository('AppBundle:Nationalite');
        $id=$user->getId();

        $dateEntree=new \DateTime($request->request->get('dateEntree'));
        $dateEntree->format('YYYY-mm-dd');
        $user->setDateEntree($dateEntree);

        $dateSortie=new \DateTime($request->request->get('dateSortie'));
        $dateSortie->format('YYYY-mm-dd');
        $user->setDateSortie($dateSortie);


        if($request->request->get('situation')=="Etudiant"){

            $user->setEtudiant(1);
            $user->setDiplome($request->request->get('diplome'));
            $em->flush();

        }elseif ($request->request->get('situation')=="Enseignant"){

            $user->setEtudiant(0);
            $em->flush();
        }
        for($i=0;$i<sizeof($tableau1);$i++){

         if ($tableau1[$i]=="actualite"){

             $user->setcliqueActualite(1);


             $dateActualite = new \DateTime('now');
             $dateActualite->format('YYYY-mm-dd');

             $user->setDateActualite($dateActualite);
             $em->flush();
         }elseif ($tableau1[$i]=="offre"){

             $user->setcliqueOffre(1);
             $dateOffre = new \DateTime('now');
             $dateOffre->format('YYYY-mm-dd');
             $user->setDateOffre($dateOffre);
             $em->flush();
         }elseif ($tableau1[$i]=="sandage"){

             $user->setcliqueSandage(1);
             $dateSandage = new \DateTime('now');
             $dateSandage->format('YYYY-mm-dd');
             $user->setDateSandage($dateSandage);
             $em->flush();
         }

        }

        for ($i=0;$i<sizeof($tableau2);$i++){

            if ($tableau2[$i]=="acceptMail"){

                $user->setacceptmail(1);
                $em->flush();
            }elseif ($tableau2[$i]=="acceptTel") {

               $user->setaccepttelephone(1);
                $em->flush();
            }
        }

        if ($request->request->get('telephone') != "") {
            $tel = new Telephone();
            $tel->setTelephone($request->request->get('telephone'));
            $tel->setUtilisateur($user);
            $user->setTelephone($request->request->get('telephone'));
            $em->persist($tel);
            $em->flush();
        }
        if ($request->request->get('nationalite') != "vide") {

            $nationalite = $nationaliteRepository->findOneBy(array('nationalite' => $request->request->get('nationalite')));

            $em = $this->getDoctrine()->getEntityManager();
            $nat = new NationaliteUser();
            $nat->setUtilisateur($user);
            $nat->setNationalite($nationalite);
            $em->persist($nat);
            $em->flush();

        }
        if ($request->request->get('competence') != "") {
            $comp = new Competence();
            $comp->setCompetence($request->request->get('competence'));
            $comp->setUtilisateur($user);
            $em->persist($comp);
            $em->flush();
        }
        if ($request->request->get('poste') != "") {
            $poste = new Poste();
            $poste->setUtilisateur($user);
            $poste->setPoste($request->request->get('poste'));
            $poste->setEntreprise($request->request->get('entreprise'));

            $datedebut = new \DateTime($request->request->get('datedebut'));
            $datedebut->format('YYYY-mm-dd');

            $datefin = new \DateTime($request->request->get('datefin'));
            $datefin->format('YYYY-mm-dd');

            $poste->setDateDeb($datedebut);
            $poste->setDateFin($datefin);
            $em->persist($poste);
            $em->flush();

        }

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


       /* Envoi de mail vers  le nouveau inscrit */



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
            $mail->addAddress($user->getEmail());               // Name is optional



            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'PrivRisk: Confirmation de votre inscription';
            $mail->Body    = ' Bonjour Monsieur '.$user->getPrenom().' '.$user->getNom().'<br>
                           \Vous êtes temporarement inscrit , en attendant la validation de votre insription par le moderateur <br>
                           ne repondez pas sur cet email .' ;
            //$mail->Body = preg_replace( array_keys( $replacements ), array_values( $replacements ), $email );
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();
            echo 'Message has been sent';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
        $listeuserRepository = $em->getRepository('AppBundle:User');
        $user = $listeuserRepository->findAll();
        $userEnvoyer=null;
        $i=0;


        foreach ($user as $u){

            if($this->userHasRole($u->getId(),"ROLE_ADMIN")==true){
                $userEnvoyer[$i]=$u;
                $i++;
            }
        }

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
            }              // Name is optional



            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'PrivRisk: Demande d addmission ';
            $mail->Body    = " Bonjour Monsieur L'administrateur <br>
                           \Vous avez une nouvelle demande d'addmission à priv'risk  , veuillez vous connectez sur votre compte pour avoir plus de details. Merci !  <br>
                           ne repondez pas sur cet email ." ;
            //$mail->Body = preg_replace( array_keys( $replacements ), array_values( $replacements ), $email );
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();
            echo 'Message has been sent';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }


       $this->addFlash(
            'token',
            'Vous êtes temporarement inscrit , en attendant la validation de votre insription par le moderateur'
        );

        return $this->redirectToRoute('lic_home_homepage');

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




}
