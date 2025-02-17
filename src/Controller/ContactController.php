<?php
namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Service\MailService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'contact.index')]
    public function index(
        Request $request,
        EntityManagerInterface $manager,
        MailService $mailService
    ): Response {
        $contact = new Contact();

        if ($this->getUser()) {
            $contact->setFullName($this->getUser()->getFullName())
                ->setEmail($this->getUser()->getEmail());
        }

        $form = $this->createForm(ContactType::class, $contact);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($contact);
            $manager->flush();

            // Send email
            $mailService->sendEmail(
                $contact->getEmail(),
                $contact->getSubject(),
                'emails/contact.html.twig',
                ['contact' => $contact]
            );

            $this->addFlash(
                'success',
                'Votre demande a été envoyée avec succès !'
            );

            return $this->redirectToRoute('contact.index');
        } elseif ($form->isSubmitted()) {
            $this->addFlash(
                'danger',
                'Il y a eu une erreur lors de l\'envoi du formulaire. Veuillez réessayer.'
            );
        }

        return $this->render('pages/contact/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
