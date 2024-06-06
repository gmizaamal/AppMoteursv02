<?php

namespace App\DataFixtures;

use App\Entity\Moteurs;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;
use App\Entity\Contact;

class AppFixtures extends Fixture
{
    private Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create('fr_FR');
    }

    public function load(ObjectManager $manager): void
    {
        // Création d'utilisateurs et de moteurs associés
        $users = [];
        for ($i = 0; $i < 10; $i++) {
            $user = new User();
            $user->setFullName($this->faker->name())
                ->setEmail($this->faker->email())
                ->setRoles(['ROLE_USER'])
                ->setPlainPassword('password');

            // Persiste l'utilisateur
            $manager->persist($user);

            // Création et association d'un moteur pour chaque utilisateur
            foreach ($users as $user) {
                $moteur = new Moteurs();
                $moteur->setMarque($this->faker->word())
                    ->setPrix(mt_rand(0, 100))
                    ->setUser($user)
                    ->setUpdateAt(new \DateTimeImmutable()); // Initialise update_at avec la date et l'heure actuelles
            
                // Persiste le moteur
                $manager->persist($moteur);
            }

            // Ajouter l'utilisateur à la liste pour référence ultérieure
            $users[] = $user;
        }

        // Appliquer les changements dans la base de données
       
    
    for ($i = 0; $i < 5; $i++) {
        $contact = new Contact();
        $contact->setFullName($this->faker->name())
            ->setEmail($this->faker->email())
            ->setSubject('Demande n°' . ($i + 1))
            ->setMessage($this->faker->text());

        $manager->persist($contact);
    }

    $manager->flush();
}

}
