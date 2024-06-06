<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Contact;
use App\Form\ContactType;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\HttpFoundation\Request;

class DefaultController extends AbstractController
{
    #[Route('/index.html', name: 'app_index')]
    public function index(): Response
    {
        return $this->render('default/index.html.twig');
    }

    #[Route('/about.html', name: 'app_about')]
    public function about(): Response
    {
        return $this->render('default/about.html.twig');
    }

    #[Route('/audi.html', name: 'app_audi')]
    public function audi(): Response
    {
        return $this->render('default/audi.html.twig');
    }

    #[Route('/blog.html', name: 'app_blog')]
    public function blog(): Response
    {
        return $this->render('default/blog.html.twig');
    }

    #[Route('/blog-details.html', name: 'app_blog_details')]
    public function blogDetails(): Response
    {
        return $this->render('default/blog-details.html.twig');
    }

    #[Route('/bmw.html', name: 'app_bmw')]
    public function bmw(): Response
    {
        return $this->render('default/bmw.html.twig');
    }

    #[Route('/caddy.html', name: 'app_caddy')]
    public function caddy(): Response
    {
        return $this->render('default/caddy.html.twig');
    }

    #[Route('/car.html', name: 'app_car')]
    public function car(): Response
    {
        return $this->render('default/car.html.twig');
    }

    #[Route('/car-details.html', name: 'app_car_details')]
    public function carDetails(): Response
    {
        return $this->render('default/car-details.html.twig');
    }

    #[Route('/contact.html', name: 'contact.index1')]
    public function contact(): Response
    {
        return $this->render('default/contact.html.twig');
    }

    #[Route('/fiat.html', name: 'app_fiat')]
    public function fiat(): Response
    {
        return $this->render('default/fiat.html.twig');
    }

    #[Route('/ford.html', name: 'app_ford')]
    public function ford(): Response
    {
        return $this->render('default/ford.html.twig');
    }

    #[Route('/golf.html', name: 'app_golf')]
    public function golf(): Response
    {
        return $this->render('default/golf.html.twig');
    }

    #[Route('/main.html', name: 'app_main')]
    public function main(): Response
    {
        return $this->render('default/main.html.twig');
    }

    #[Route('/Mercedes.html', name: 'app_mercedes')]
    public function mercedes(): Response
    {
        return $this->render('default/Mercedes.html.twig');
    }

    #[Route('/Nessan.html', name: 'app_nessan')]
    public function nessan(): Response
    {
        return $this->render('default/Nessan.html.twig');
    }

    #[Route('/Partner.html', name: 'app_partner')]
    public function partner(): Response
    {
        return $this->render('default/Partner.html.twig');
    }

    #[Route('/peice.html', name: 'app_peice')]
    public function peice(): Response
    {
        return $this->render('default/peice.html.twig');
    }
}
