<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Participants;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;


/**
 * @Route("/participants")
 */
class ParticipantsController extends Controller
{
    /**
     * @Route("/", name="participantsPage")
     */
    public function listAction()
    {
    	$doctrine = $this->getDoctrine();
        $repository = $doctrine->getRepository('AppBundle:Participants');
        $query = $repository->createQueryBuilder('p')
                ->orderBy('p.id','DESC')
                ->getQuery();
        $participants = $query->getResult();

        return $this->render('@App/Participants/list.html.twig',[
        	"participants" => $participants
        ]);
    }

    /**
     * @Route("/add")
     */
    public function addAction(Request $request)
    {
        $participant =  [
            "score" => (!empty($_GET['score']) ?  $_GET['score'] : 0),
            "username" => "" 
        ];
        $participant = new Participants($participant);
        //Create a form
        $form = $this->createFormBuilder($participant)
            ->add('username', TextType::class, [
                "attr" => [
                    "class" => "form-control",
                    "placeholder" => "Enter your username"
                ]
            ])
            ->add('save', SubmitType::class, [
                "label" => "Save score",
                "attr" => ["class" => "btn btn-primary mt-2"]
            ])
            ->getForm();

        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid())
        {
            $participant = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            //Begin a transaction
            $entityManager->persist($participant);
            //Add participant to database
            $entityManager->flush();
            //Redirect to participants list with flash success message
            $this->addFlash('success','Your score has been successfully saved.');
            return $this->redirectToRoute("participantsPage");


        }    
        
        /*$entityManager = $this->getDoctrine()->getManager();
        //Begin a transaction
        $entityManager->persist($participant);
        //Add participant to database
        if ($entityManager->flush())
        {
            $session = $request->getSession();
            $session->getFlashBag()->add('success','You have been registered successfully.');
        }
    */
        
        return $this->render('@App/Participants/add.html.twig', [
            "form" => $form->createView()
        ]);
    }
}
