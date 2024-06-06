<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\RedirectResponse;

class SecurityController extends AbstractController
{
    /**
     * This controller allows us to login
     *
     * @param AuthenticationUtils $authenticationUtils
     * @return Response
     */
    #[Route('/connexion', name: 'security.login', methods: ['GET', 'POST'])]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // Retrieve the logged-in user, if exists
        $user = $this->getUser();
        
        // If the user is logged in, redirect them to the page for creating a new moteur
        if ($user instanceof User) {
            return $this->redirectToRoute('moteur.new');
        }
        
        // If the user is not logged in, display the login page normally
        return $this->render('pages/security/login.html.twig', [
            'last_username' => $authenticationUtils->getLastUsername(),
            'error' => $authenticationUtils->getLastAuthenticationError()
        ]);
    }

    /**
     * This controller allows us to logout
     *
     * @return void
     */
    #[Route('/deconnexion', 'security.logout')]
    public function logout()
    {
        // Nothing to do here..
    }

     /**
 * This controller allows users to register.
 *
 * @param Request $request
 * @param EntityManagerInterface $manager
 * @return Response
 */
#[Route('/inscription', name: 'security.registration', methods: ['GET', 'POST'])]
public function registration(Request $request, EntityManagerInterface $manager): Response
{
    $user = new User();

    $form = $this->createForm(RegistrationType::class, $user);

    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
        // Automatically assign ROLE_USER when a user is registered
        $user->setRoles(['ROLE_USER']);

        $this->addFlash(
            'success',
            'Votre compte a bien été créé.'
        );

        $manager->persist($user);
        $manager->flush();

        return $this->redirectToRoute('security.login');
    }

    return $this->render('pages/security/registration.html.twig', [
        'form' => $form->createView()
    ]);
}}