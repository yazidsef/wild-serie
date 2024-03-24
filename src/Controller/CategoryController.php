<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\CategoryRepository;
use App\Repository\ProgramRepository;
use App\Entity\Category;

#[Route('/category', name: 'category_')]
class CategoryController extends AbstractController
{
    #[Route('', name: 'index')]
    public function index(CategoryRepository $categoryRepository): Response
    {
        $cateogories=$categoryRepository->findAll();
        return $this->render('category/index.html.twig', [
            'controller_name' => 'CategoryController',
            'categories'=>$cateogories
        ]);
    }
    #[Route('/{categoryName}',name:'show')]
    public function show(string $categoryName , CategoryRepository $categoryRepository ,ProgramRepository $programRepository){
        //ici j'ai recuperer la categorie comme son nom indique dans la bdd 
        $categories = $categoryRepository->findOneBy(['name'=>$categoryName]);
        if(!$categories)
        {
            throw $this->createNotFoundException('this category not found');
        }
        //ici j'ai recuperer les programmes qui sont lier a cette categorie 
        $programs=$programRepository->findBy(['category'=>$categories],['id'=>'DESC']);
        return $this->render('category/show.html.twig',['category'=>$categories,'programs'=>$programs]);
    }
   
}
