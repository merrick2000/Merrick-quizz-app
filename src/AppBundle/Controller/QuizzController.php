<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Questions;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

/**
* @Route("/quiz")
*/
class QuizzController extends Controller
{

    /**
    * @Route("/", name="quizPage")
    */
    public function showQuizAction()
    {
        return $this->render('@App/Quizz/quizz.html.twig', ["startQuiz"=>1]);
    }
    /**
     * @Route("/questions/{action}", name="questionsList")
     */
    public function listAction($action = "show")
    {
        $doctrine = $this->getDoctrine();
        $repository = $doctrine->getRepository('AppBundle:Questions');
        $query = $repository->createQueryBuilder('q')
                ->orderBy('q.id','ASC')
                ->getQuery();
        $questions = $query->getResult();
        $questionsArray = [];
        foreach ($questions as $key => $value) 
        {
            $questionsArray[$key]["id"] = $value->getId();  
            $questionsArray[$key]["question"] = $value->getText();  
            $questionsArray[$key]["answers"] = explode('|', $value->getAnswers());
            if(strstr($value->getCorrectAnswerId(), ','))
            {
                $questionsArray[$key]["correct_answer_id"] = explode(',', $value->getCorrectAnswerId());
            }
            else
            {
                $questionsArray[$key]["correct_answer_id"] = $value->getCorrectAnswerId();
            }
        }
        
       
        if ($action == "json") 
        {
            return $this->json(["code"=>200, "questions"=>$questionsArray ], 200);
        }
        else if (empty($action) || (is_string($action) && $action !=="json") ) 
        {
            return $this->render('@App/questionsList.html.twig', [
                "questions" => $questionsArray
            ]);
        }
        

        /*$this->render('@App/questionsList.html.twig', [
            "questions" => $questions
        ]);*/
    }

    /**
     * @Route("/add", name="addQuestion")
     */
    public function addAction(Request $request)
    {
        
        $quizData = [
            "question" => "",
            "answers" => "",
            "correct_answer_id" => "",
            "created_at" => new \DateTime()
        ];   
        if($request->getMethod() == Request::METHOD_POST && $request->isXmlHttpRequest())
        {
            $quiz = json_decode($request->getContent());
            $quizData = [
                "question" => $quiz->question,
                "answers" => $quiz->answers,
                "correct_answer_id" => $quiz->correctIndex,
                "created_at" => new \DateTime()
            ];

            if(count($quizData['answers']) > 1)
            {
                $quizData['answers'] = implode("|", $quizData['answers']);
            }

            if(count($quizData['correct_answer_id']) > 1)
            {
                $quizData['correct_answer_id'] = implode(",", $quizData['correct_answer_id']);
            }
            else
            {
                $quizData['correct_answer_id'] = $quizData['correct_answer_id'][0];
            }

            $question = new Questions($quizData);

            $entityManager = $this->getDoctrine()->getManager();
            //Begin a transaction
            $entityManager->persist($question);

            //Add question to database
            $entityManager->flush();

            return $this->json(["code"=>200, "message"=>"Question successfully added." ], 200);
        }
        else
        {
            return $this->json(["code"=>200, "message"=>"Ok"], 200);
        }
        
    }
    /**
    * @Route("/delete/{question}", name="deleteQuestion")
    */
    public function deleteAction(Questions $question = null)
    {
        if (!$question) 
        {
            $this->addFlash('error',"The question you are trying to delete does not exists.");
        }
        else
        {
            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->remove($question);

            $entityManager->flush();

            $this->addFlash('success',"Question deleted successfully.");
        }
        return $this->forward('AppBundle:Quizz:list');
    }

    /**
    * @Route("/update/{id}", name="updateQuestion")
    */
    public function updateAction($id)
    {
        $data = [
            "question" => "",
            "answers" => "",
            "correct_answer_id" => "",
            "created_at" => new \DateTime()
        ];
        $data = new Questions($data);

        $doctrine = $this->getDoctrine();
        $repository = $doctrine->getRepository('AppBundle:Questions');
        $question = $repository->find($id);
        if($question)
        {
            $question = [
                "text" => $question->getText(),
                "answers" => explode('|', $question->getAnswers()),
                "correct_answer_id" => $question->getCorrectAnswerId(),
                "created_at" => $question->getCreatedAt()
            ];
        }
        
        //dump($question);exit();

        //Create forms
        //update insruction here
        return $this->render('@App/updateQuestion.html.twig', ["question" => $question]);
    }


}
