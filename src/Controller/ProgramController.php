<?php 
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProgramRepository;
use App\Entity\Program;
use App\Entity\Season;
use App\Entity\Episode;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Form\ProgramType;
use Symfony\Component\Validator\Validator\ValidatorInterface;
//ça c'est la route general de programController 
#[Route('/program',name:'program_')]
class ProgramController extends AbstractController
{

    #[Route('',name:'index')]
    public function index(ProgramRepository $programRepository):Response
    {
        //on utilise findAll() et findOneBy() et findBy() pour recuperer et afficher les données de la badd de données
        $programs=$programRepository->findAll();
        return $this->render('program/index.html.twig', ['website' => 'Wild Series','programs'=>$programs]);  
    }
    #[Route('/newSerie',name:'new_serie')]
    public function new(Request $request,EntityManagerInterface $entityManager ,ValidatorInterface $validator):Response{
        $program = new Program();
        $form = $this->createForm(ProgramType::class,$program);
        $form->handleRequest($request);


        if($form->isSubmitted()){
            $errors=$validator->validate($program);
            if(count($errors)>0){
                return $this->render('program/new_serie.html.twig',[
                    'form'=>$form->createView(),
                    'errors'=>$errors
                ]);
            }
            $entityManager->persist($program);
            $entityManager->flush();
            $this->addFlash('success','le program a été bien ajouter');
            return $this->redirectToRoute('program_index');
        }
        return $this->render('program/new_serie.html.twig',['form'=>$form]);

    }
    //ici la methode est GET le parametre est id on vas faire le regex
    //
    #[Route('/{id}',name:'details',methods:['GET'],requirements:['page'=>'\d+'])]

    public function show(Program $program):Response
    {   
        if (!$program) {
            
            throw $this->createNotFoundException(
                'No program with id  found in program\'s table.'
            );
        }
        return $this->render('program/view.html.twig', [
            'program' => $program,
        ]);
        
    }
    #[Route('{program}/seasons/{season}',name:'season_show',methods:['GET'])]
    public function showSeason(Program $program,Season $season):Response{

        
        if(!$program || !$season){
            throw $this->createNotFoundException('there is program and no season in this link');
        }
        return $this->render('program/season_show.html.twig',['season'=>$season,'program'=>$program]);
    }
    #[Route('{program}/seasons/{season}/episode/{episode}',name:'episode_show',methods:['GET'])]
    public function showEpisode(Season $season , Program $program , Episode $episode):Response
    {
        if(!$program || !$episode || !$season){
            throw $this->createNotFoundException('data not found !!!');
        }
        return $this->render('program/episode_show.html.twig',['episodes'=>$episode,'season'=>$season,'program'=>$program]);
    }
  
}