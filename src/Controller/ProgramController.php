<?php 
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


//ça c'est la route general de programController 
#[Route('/program',name:'program_')]
class ProgramController extends AbstractController
{

    #[Route('',name:'index')]
    public function index():Response
    {
        return $this->render('program/index.html.twig', ['website' => 'Wild Series']);  
    }
    //ici la methode est GET le parametre est id on vas faire le regex
    //
    #[Route('/{id}',name:'details',methods:['GET'],requirements:['page'=>'\d+'])]

    public function show(int $id):Response
    {
        return $this->render('program/view.html.twig', ['website' => 'Wild Series','id'=>$id]);  
        
    }
}