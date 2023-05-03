<?php

namespace App\Controller;

use App\Entity\Todo;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Persistence\ObjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/todo')]
class TodoController extends AbstractController
{
    private ObjectManager $manager;
    private ObjectRepository $repository;
    public function  __construct(private ManagerRegistry $doctrine)
    {
        $this->manager = $this->doctrine->getManager();
        $this->repository = $this->doctrine->getRepository(Todo::class);
    }

    #[Route('/', name: 'app_todo')]
    public function index(SessionInterface $session): Response
    {

        $todos = $this->repository->findByExampleField('lundi');
        $todos = $this->repository->findAll();
        $this->addFlash('info', "Bienvenu dans votre gestionnaire de Todo");
        return $this->render('todo/index.html.twig', [
            'todos' => $todos
        ]);
    }

    #[Route('/add/{name}/{content}', name: 'add_todo')]
    public function addTodo($name, $content) {
        $todo = new Todo();
        $todo->setName($name);
        $todo->setContent($content);
        $this->manager->persist($todo);
//        $todo2 = new Todo();
//        $todo2->setName($name.'2');
//        $todo2->setContent($content.'2');
//        // Je le mets dans la transaction
//        $this->manager->persist($todo2);
        // Exécute la transaction
        $this->manager->flush();
        $this->addFlash('success', "Le todo $name a été ajouté avec succès");

        return $this->redirectToRoute('app_todo');
    }

    #[Route('/delete/{id}', name: 'delete_todo')]
    public function deleteTodo(Todo $todo = null) {
//        dd($todo);
        if($todo) {
            $this->manager->remove($todo);
            $this->manager->flush();
            $this->addFlash('success', "Le todo $id a été supprimé avec succès");
        } else {
            $this->addFlash('error', "Le todo $id n'existe pas ");
        }
        return $this->redirectToRoute('app_todo');
    }
}
