<?php

namespace App\Controller\Rdv;

use App\Entity\FichePatient;
use App\Entity\Rdv;
use App\Entity\Utilisateur;
use App\Form\RdvType;
use App\Repository\CentreRepository;
use App\Repository\RdvRepository;
use App\Repository\UtilisateurRepository;
use League\Csv\Writer;
use Swift_Mailer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class RdvController extends AbstractController
{
    /**
     * @Route("/chercherRndv", name="rdv")
     */
    public function index(): Response
    {
        return $this->render('rdv/index.html.twig', [
            "rdvList" => null, "show" => 0, "user" => null
        ]);
    }
    /**
     * @Route("/listfichJson", name="addJson")
     */
    public function listFichJson(SerializerInterface $normalizer)
    {

        $FichePatient = $this->getDoctrine()->getRepository(Rdv::class)->findAll();


        $json_Content = $normalizer->normalize(
            $FichePatient,
            'json',
            ['groups' => 'post:read']
        );
        return new Response(json_encode($json_Content));
    }

    /**
     * @Route("/listfichJsonC", name="addJsonC")
     */
    public function listFichJsonC(SerializerInterface $normalizer)
    {

        $FichePatient = $this->getDoctrine()->getRepository(Utilisateur::class)->findAll();


        $json_Content = $normalizer->normalize(
            $FichePatient,
            'json',
            ['groups' => 'post:read']
        );
        return new Response(json_encode($json_Content));
    }

    /**
     * @Route("/addJsoon/{nom}/{prenom}/{id}/{date}", name="addJsoon")
     */
    public function AddJson(UtilisateurRepository $rp,$nom,$prenom,$id,$date,SerializerInterface $normalizer,\Swift_Mailer $mailer)
    {
        $cent = $rp->findOneBy(['idUtilisateur' => $id ]);
        $fiche = new rdv();
        $fiche->setDate($date);
        $fiche->setEmail("wiam.askri@esprit.tn");
        $fiche->setIdClient(2);
        $fiche->setIdCoach($cent);

        $fiche->setNcoach($nom."".$prenom);
        $em = $this->getDoctrine()->getManager();
        $em->persist($fiche);
        $em->flush();
         $MessageBird = new \MessageBird\Client('AnNngCIpbDdqjn0WFfLgKIUCq');
         $Message = new \MessageBird\Objects\Message();
         $Message->originator = 'FanfArt';
         $Message->recipients = "+21699260696";
         $Message->body = 'Coach Un nouveaux Rendez-Vous a été ajouter';
         $MessageBird->messages->create($Message);
        $message = (new \Swift_Message('Rendez-Vous'))
            ->setFrom('wellnessmailer@gmail.com')
            ->setTo("wiam.askri@esprit.tn")
            ->setBody(
                $this->renderView(
                    '/par.html.twig',
                    compact('fiche')

                ),
                'text/html'
            )
        ;
        $mailer->send($message);
        $json_Content = $normalizer->normalize(
            $fiche,
            'json',
            ['groups' => 'post:read']
        );
        return new Response(json_encode($json_Content));


    }

    /**
     * @Route("/deleteJson/{id}", name="delJsoon")
     */
    function DeleteJson(int $id,SerializerInterface $normalizer)
    {
        $repo = $this->getDoctrine()->getRepository(rdv::class);
        $entityManage = $this->getDoctrine()->getManager();
        $fiche = $repo->find($id);
        $entityManage->remove($fiche);
        $entityManage->flush();
        $json_Content = $normalizer->normalize(
            $fiche,
            'json',
            ['groups' => 'post:read']
        );
        return new Response(json_encode($json_Content));
    }
    /**
     * @Route("/findUserBy/{id}", name="findUser")
     * @param UtilisateurRepository $userRepo
     * @param $id
     * @return Response
     */
    public function findUser(UtilisateurRepository $userRepo, $id): Response
    {
        $user = $userRepo->findOneBy(["idUtilisateur"=>$id]);
        if ($user == null) {
            return new Response("0");
        } else {
            return new Response("1");
        }
    }


    /**
     * @Route("/rendezvous/{id}", name="rendezVous")
     * @param RdvRepository $rdvRepo
     * @param UtilisateurRepository $userRepo
     * @param $id
     * @return Response
     */
    public function rendezVous(RdvRepository $rdvRepo, UtilisateurRepository $userRepo, $id): Response
    {
        $user = $userRepo->findOneBy(["idUtilisateur"=>$id]);
        $clients = [];
        if($user->getType() == "coach") {
            $rdvList = $rdvRepo->findBy(["idCoach"=>$id]);
            $i = 0;
            foreach($rdvList as $rd) {
            $clients[$i] = $userRepo->findOneBy(["idUtilisateur" =>$rd->getIdClient()]);
            $i++;
            }
        } else {
        $rdvList = $rdvRepo->findBy(["idClient"=>$id]);
        }
        $rdvList = array_map(null,$rdvList, $clients);
        return $this->render('rdv/index.html.twig', ["type" =>$user->getType(),
            "rdvList" => $rdvList, "show" => 1, "user" =>$user
        ]);
    }

    /**
     * @Route("/deleteRdv/{id}/{idUser}", name="delRdv")
     * @param RdvRepository $rdvRepo
     * @param $id
     * @param $idUser
     * @param UtilisateurRepository $userRepo
     * @param Swift_Mailer $mailer
     * @return RedirectResponse
     */
    public function delRdv(RdvRepository $rdvRepo, $id, $idUser, UtilisateurRepository $userRepo, Swift_Mailer $mailer)
    {

        $rdv = $rdvRepo->findOneBy( ["id" => $id]);
        $date = $rdv->getDate();
        $clientId = $rdv->getIdClient();
        $coachEmail = $rdv->getIdCoach()->getEmail();
        $user = $userRepo->findOneBy(["idUtilisateur"=>$idUser]);
        $entityManage=$this->getDoctrine()->getManager();
        $entityManage->remove($rdv);
        $entityManage->flush();
        if($user->getType() =="coach") {
            $sender = "coach";
            $u = $userRepo->findOneBy(["idUtilisateur"=>$clientId]);
            $email = $u->getEmail();
            $otherEmail = $coachEmail;
        } else {
            $sender = "user";
            $email = $coachEmail;
            $otherEmail = $user->getEmail();
        }

        $message = (new \Swift_Message('Hello Email'))
            ->setFrom('wellnessMailer@gmail.com')
            ->setTo($email)
            ->setBody(
                $this->renderView(
                    'rdv/delEmail.html.twig',
                    ["date" => $date, "sender" => $sender, "otherEmail" =>$otherEmail]

                ),
                'text/html'
            )
            ->setSubject("Rendez-vous");
        $mailer->send($message);

        return $this->redirect("/rendezvous/".$user->getIdUtilisateur());
    }

    /**
     * @Route("/refreshCalendar/{id}", name="refreshCal")
     * @param RdvRepository $rdvRepo
     * @param $id
     * @param UtilisateurRepository $userRepo
     */
    public function refReshCal(RdvRepository $rdvRepo, $id, UtilisateurRepository $userRepo)
    {
        $user = $userRepo->findOneBy(["idUtilisateur"=>$id]);
        $rdvs = $rdvRepo->findBy(["idCoach" => $user->getIdUtilisateur()]);
        $dates = [];
        $i = 0;
        foreach($rdvs as $rdv) {
            $dates[$i] = $rdv->getDate();
            $i++;
        }
        return new JsonResponse($dates);
    }


    /**
     * @Route("/updateRdv/{id}/{idUser}", name="updateRdv")
     * @param RdvRepository $rdvRepo
     * @param Request $request
     * @param $id
     * @param $idUser
     * @param UtilisateurRepository $userRepo
     * @param Swift_Mailer $mailer
     * @return RedirectResponse|Response
     */
    public function updateRdv(RdvRepository $rdvRepo,Request $request, $id, $idUser, UtilisateurRepository $userRepo, Swift_Mailer $mailer)
    {
        $dates = [];

        $rdv = $rdvRepo->findOneBy( ["id" => $id]);
        $oldDate = $rdv->getDate();
        $coachId = $rdv->getIdCoach()->getIdUtilisateur();
        $rdvs = $rdvRepo->findBy(["idCoach" => $coachId]);
        $i = 0;
        foreach($rdvs as $rd) {
            $dates[$i] = $rd->getDate();
            $i++;
        }
        $user = $userRepo->findOneBy(["idUtilisateur"=>$idUser]);
        $form=$this->createForm(RdvType::class, $rdv);
        $form->add("Sauvegarder", SubmitType::class, [
            'attr' => ['class' => 'btn btn-info'],
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em=$this->getDoctrine()->getManager();
            $em->flush();
            if($oldDate != $rdv->getDate()) {
            // send email to user
            $message = (new \Swift_Message('Hello Email'))
                ->setFrom('wellnessMailer@gmail.com')
                ->setTo($rdv->getEmail())
                ->setBody(
                    $this->renderView(
                        'rdv/updateEmail.html.twig',
                        ["oldDate" => $oldDate, "newDate" => $rdv->getDate()]


                    ),
                    'text/html'
                )
                ->setSubject("Rendez-vous");
            $mailer->send($message);


            // send email to coach
            $message = (new \Swift_Message('Hello Email'))
                ->setFrom('wellnessMailer@gmail.com')
                ->setTo($rdv->getIdCoach()->getEmail())
                ->setBody(
                    $this->renderView(
                        'rdv/updateEmail.html.twig',
                        ["oldDate" => $oldDate, "newDate" => $rdv->getDate()]

                    ),
                    'text/html'
                )
                ->setSubject("Rendez-vous");
            $mailer->send($message);
            }
            return $this->redirect("/rendezvous/" . $user->getIdUtilisateur());
        }
        return $this->render("rdv/addRdv.html.twig", [
            'user'=>$user,
            'dates' =>$dates,
            'rdv' => $rdv,
            'form' =>$form->createView(),
        ]);
    }

    /**
     * @Route("/addRdv/{id}", name="addRdv")
     * @param RdvRepository $rdvRepo
     * @param Request $request
     * @param $id
     * @param UtilisateurRepository $userRepo
     * @param Swift_Mailer $mailer
     * @return RedirectResponse|Response
     */
    public function addRdv(RdvRepository $rdvRepo,Request $request, $id, UtilisateurRepository $userRepo, Swift_Mailer $mailer)
    {
        $dates = [];

        $rdv = new Rdv();
        $coachs = $userRepo->findBy(["type" =>"coach"]);
        $rdvs = $rdvRepo->findBy(["idCoach" => $coachs[0]->getIdUtilisateur()]);
        $i = 0;
        foreach($rdvs as $rd) {
            $dates[$i] = $rd->getDate();
            $i++;
        }
        $user = $userRepo->findOneBy(["idUtilisateur"=>$id]);
        $form=$this->createForm(RdvType::class, $rdv);
        $form->add("Sauvegarder", SubmitType::class, [
            'attr' => ['class' => 'btn btn-info'],
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $rdv->setEmail($user->getEmail());
            $rdv->setIdClient($user->getIdUtilisateur());
            $em=$this->getDoctrine()->getManager();
            $em->persist($rdv);
            $em->flush();

            // send email to user
            $message = (new \Swift_Message('Hello Email'))
                ->setFrom('wellnessMailer@gmail.com')
                ->setTo($user->getEmail())
                ->setBody(
                    $this->renderView(
                        'rdv/email.html.twig',
                        ["status" => "user", 'userName' => $user->getFullName(), "userEmail"=>$user->getEmail(), "date" => $rdv->getDate(), "coachName" =>$rdv->getIdCoach()->getFullName(),"coachEmail"=>$rdv->getIdCoach()->getEmail()]


                    ),
                    'text/html'
                )
                ->setSubject("Rendez-vous");
            $mailer->send($message);


            // send email to coach
            $message = (new \Swift_Message('Hello Email'))
                ->setFrom('wellnessMailer@gmail.com')
                ->setTo($rdv->getIdCoach()->getEmail())
                ->setBody(
                    $this->renderView(
                        'rdv/email.html.twig',
                        ["status" => "coach", 'userName' => $user->getFullName(), "userEmail"=>$user->getEmail(), "date" => $rdv->getDate(), "coachName" =>$rdv->getIdCoach()->getFullName(),"coachEmail"=>$rdv->getIdCoach()->getEmail()]


                    ),
                    'text/html'
                )
                ->setSubject("Rendez-vous");
            $mailer->send($message);


            return $this->redirect("/rendezvous/" . $user->getIdUtilisateur());
        }
        return $this->render("rdv/addRdv.html.twig", [
            'user'=>$user,
            'dates' =>$dates,
            'rdv' => $rdv,
            'form' =>$form->createView(),
        ]);
    }

    /**
     * @Route("/expoerCSV/{id}", name="exportCSV")
     * @param RdvRepository $rdvRepo
     * @param UtilisateurRepository $userRepo
     * @param $id
     * @throws \League\Csv\CannotInsertRecord
     */
    public function exportCSV(UtilisateurRepository $userRepo, $id)
    {
        $user = $userRepo->findOneBy(["idUtilisateur"=>$id]);


        $header = ['Nom de client', 'Email', 'Date rendez-vous'];
        $rdvs = [];
        $i=0;
        foreach($user->getRdvList() as $rdv) {
            $user = $userRepo->findOneBy(["idUtilisateur"=>$rdv->getIdClient()]);
            $rdvs[$i] = [$user->getFullName(),$rdv->getEmail(),$rdv->getDate()];
            $i++;
        }
        //load the CSV document from a string
        $csv = Writer::createFromString();

        //insert the header
        $csv->insertOne($header);

        //insert all the records
        $csv->insertAll($rdvs);
        $csv->output('users.csv');
        exit();
    }

}
