<?php 
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProgramRepository;

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
    //ici la methode est GET le parametre est id on vas faire le regex
    //
    #[Route('/{id}',name:'details',methods:['GET'],requirements:['page'=>'\d+'])]

    public function show(int $id, ProgramRepository $programRepository):Response
    {   
        $program = $programRepository->findOneBy(['id' => $id]);
        // same as $program = $programRepository->find($id);
    
        if (!$program) {
            
            throw $this->createNotFoundException(
                'No program with id : '.$id.' found in program\'s table.'
            );
        }
        return $this->render('program/view.html.twig', [
            'program' => $program,
        ]);
        
    }
    #[Route('{id}/seasons/{seasonId}',name:'program_season_show',methods:['GET'])]
    public function showSeason(int $programId , int $seasonId){

    }
}