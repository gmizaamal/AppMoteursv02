<?php

namespace App\Test\Controller;

use App\Entity\Moteurs;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MoteursControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $repository;
    private string $path = '/moteur/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->repository = $this->manager->getRepository(Moteurs::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Moteur index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'moteur[marque]' => 'Testing',
            'moteur[prix]' => 'Testing',
            'moteur[ref]' => 'Testing',
            'moteur[description]' => 'Testing',
            'moteur[imageName]' => 'Testing',
            'moteur[updateAt]' => 'Testing',
            'moteur[createdAt]' => 'Testing',
            'moteur[cylinder]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->repository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Moteurs();
        $fixture->setMarque('My Title');
        $fixture->setPrix('My Title');
        $fixture->setRef('My Title');
        $fixture->setDescription('My Title');
        $fixture->setImageName('My Title');
        $fixture->setUpdateAt('My Title');
        $fixture->setCreatedAt('My Title');
        $fixture->setCylinder('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Moteur');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Moteurs();
        $fixture->setMarque('Value');
        $fixture->setPrix('Value');
        $fixture->setRef('Value');
        $fixture->setDescription('Value');
        $fixture->setImageName('Value');
        $fixture->setUpdateAt('Value');
        $fixture->setCreatedAt('Value');
        $fixture->setCylinder('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'moteur[marque]' => 'Something New',
            'moteur[prix]' => 'Something New',
            'moteur[ref]' => 'Something New',
            'moteur[description]' => 'Something New',
            'moteur[imageName]' => 'Something New',
            'moteur[updateAt]' => 'Something New',
            'moteur[createdAt]' => 'Something New',
            'moteur[cylinder]' => 'Something New',
        ]);

        self::assertResponseRedirects('/moteur/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getMarque());
        self::assertSame('Something New', $fixture[0]->getPrix());
        self::assertSame('Something New', $fixture[0]->getRef());
        self::assertSame('Something New', $fixture[0]->getDescription());
        self::assertSame('Something New', $fixture[0]->getImageName());
        self::assertSame('Something New', $fixture[0]->getUpdateAt());
        self::assertSame('Something New', $fixture[0]->getCreatedAt());
        self::assertSame('Something New', $fixture[0]->getCylinder());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Moteurs();
        $fixture->setMarque('Value');
        $fixture->setPrix('Value');
        $fixture->setRef('Value');
        $fixture->setDescription('Value');
        $fixture->setImageName('Value');
        $fixture->setUpdateAt('Value');
        $fixture->setCreatedAt('Value');
        $fixture->setCylinder('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/moteur/');
        self::assertSame(0, $this->repository->count([]));
    }
}
