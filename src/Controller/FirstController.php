<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class FirstController extends AbstractController
{
    #[Route('/first/{name}', name: 'app_first')]
    public function index($name, Request $request, SessionInterface $session): Response
    {
        if ($session->has('nbVisite')) {

            $nbVisite = $session->get('nbVisite');
            $nbVisite++;
            $message = "Merci pourt votre fidiélité c'est votre $nbVisite visites";
            $session->set('nbVisite', $nbVisite);
        } else {
            $this->addFlash('success', 'Nouveau user');
            $session->set('nbVisite', 1);
            $message = "Bienvenu chez nous";
        }
//        return new Response('<h1>Hello GL2G2</h1>');
        return $this->render('first/index.html.twig', [
            'controller_name' => $name,
            'message' => $message
        ]);
    }
}
