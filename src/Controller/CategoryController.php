<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\CategoryRepository;
use App\Repository\ProgramRepository;
use App\Entity\Category;
use App\Form\CategoryType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
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
    #[Route('/new', name: 'new')]
    public function new(Request $request , EntityManagerInterface $entityManager ):Response
    {
        //create a new category object
        $category=new Category();

        //create the associated form by calling the categoryType 
        $form = $this->CreateForm(CategoryType::class,$category);

        //get data from the http request
        $form->handleRequest($request);

        //verify if the form is submmited

        if($form->isSubmitted() && $form->isValid()){
            //here we deal with the submitted data for exemple 
            //persist and flush the entity reddirect route ...
            $entityManager->persist($category);
            $entityManager->flush();
            $this->addFlash('success','category ajouter avec succés');
            //redirect to categories list
            return $this->redirectToRoute('category_index');
        }

        //then i make render to the the twig page
        return $this->render('category/new.html.twig',['form'=>$form]);
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
    #[Route('/{id}/edit',name:'edit')]
    public function edit(Request $request , Category $category , EntityManagerInterface $entityManager):Response
    {
        
        $form=$this->CreateForm(CategoryType::class,$category);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $entityManager->flush();
            $this->addFlash('success','category modifier avec succés');
           return  $this->redirectToRoute('category_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('category/edit.html.twig',['form'=>$form,'category'=>$category]);
    }

    #[Route('/{id}/delete',name:'delete')]
    public function delete(Request $request, Category $category, EntityManagerInterface $entityManager): Response
{
    if ($this->isCsrfTokenValid('delete'.$category->getId(), $request->request->get('_token'))) {
        $entityManager->remove($category);
        $entityManager->flush();
        $this->addFlash('danger','category supprimer');
    }

    return $this->redirectToRoute('category_index');
}
    
}
