<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/todo')]
class TodoController extends AbstractController
{
    #[Route('/', name: 'app_todo')]
    public function index(SessionInterface $session): Response
    {
        if (!$session->has('todos')) {
            $todos = array(
                'achat'=>'acheter clé usb',
                'cours'=>'Finaliser mon cours',
                'correction'=>'corriger mes examens'
            );
            $session->set('todos', $todos);
            $this->addFlash('info', "Bienvenu dans votre gestionnaire de Todo");
        }
        return $this->render('todo/index.html.twig');
    }
    #[Route('/delete/{id}', name: 'delete_todo')]
    public function deleteTodo($id, SessionInterface $session) {
        if ($session->has('todos')) {
            $todos = $session->get('todos');
            if (isset($todos[$id])) {
                unset($todos[$id]);
                $session->set('todos', $todos);
                $this->addFlash('success', "Le todo $id a été supprimé avec succès");
            } else {
                $this->addFlash('error', "Le todo $id n'existe pas ");
            }
        } else {
            $this->addFlash('error', " Brabi 3lach !!!!!!");
        }
        return $this->redirectToRoute('app_todo');
    }
}
