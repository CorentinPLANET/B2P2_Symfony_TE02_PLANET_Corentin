<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ConnexionType;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class ConnexionController extends AbstractController
{
    #[Route('/', name: 'app_connexion')]
    public function index(Request $request, UserRepository $userRepository): Response
    {
        $session = $request->getSession();

        if ($session->get("userId") == Null) {

            $user = new User;
            $form = $this->createForm(ConnexionType::class, $user);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $data = $form->getData();

                $user = $userRepository->findOneBy([
                    'email' => $data->getEmail()
                ]);

                if ($user) {
                    $session->set('userId', $user->getId());

                    return $this->redirectToRoute('app_index');
                }
            }

            return $this->render('connexion/index.html.twig', [
                'form' => $form
            ]);
        } else {
            return $this->redirectToRoute('app_index', [], Response::HTTP_SEE_OTHER);
        }
    }
    #[Route('/homepage', name: 'app_index')]
    public function homepage(Request $request): Response
    {
        $session = $request->getSession();
        if ($session->get("userId") == Null) {
            return $this->redirectToRoute('app_connexion_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('homepage/index.html.twig', [
            "userId" => $session->get("userId")
        ]);
    }
    #[Route('/logout', name: 'app_logout')]
    public function logout(Request $request): Response
    {
        $session = $request->getSession();
        $session->invalidate();

        return $this->redirectToRoute('app_connexion');
    }
}
