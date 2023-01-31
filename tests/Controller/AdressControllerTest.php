<?php

namespace App\Test\Controller;

use App\Entity\Adress;
use App\Repository\AdressRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AdressControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private AdressRepository $repository;
    private string $path = '/adress/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(Adress::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Adress index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $originalNumObjectsInRepository = count($this->repository->findAll());

        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'adress[fullname]' => 'Testing',
            'adress[company]' => 'Testing',
            'adress[address]' => 'Testing',
            'adress[complement]' => 'Testing',
            'adress[phone]' => 'Testing',
            'adress[city]' => 'Testing',
            'adress[codepostal]' => 'Testing',
            'adress[country]' => 'Testing',
            'adress[userAdress]' => 'Testing',
        ]);

        self::assertResponseRedirects('/adress/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Adress();
        $fixture->setFullname('My Title');
        $fixture->setCompany('My Title');
        $fixture->setAddress('My Title');
        $fixture->setComplement('My Title');
        $fixture->setPhone('My Title');
        $fixture->setCity('My Title');
        $fixture->setCodepostal('My Title');
        $fixture->setCountry('My Title');
        $fixture->setUserAdress('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Adress');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Adress();
        $fixture->setFullname('My Title');
        $fixture->setCompany('My Title');
        $fixture->setAddress('My Title');
        $fixture->setComplement('My Title');
        $fixture->setPhone('My Title');
        $fixture->setCity('My Title');
        $fixture->setCodepostal('My Title');
        $fixture->setCountry('My Title');
        $fixture->setUserAdress('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'adress[fullname]' => 'Something New',
            'adress[company]' => 'Something New',
            'adress[address]' => 'Something New',
            'adress[complement]' => 'Something New',
            'adress[phone]' => 'Something New',
            'adress[city]' => 'Something New',
            'adress[codepostal]' => 'Something New',
            'adress[country]' => 'Something New',
            'adress[userAdress]' => 'Something New',
        ]);

        self::assertResponseRedirects('/adress/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getFullname());
        self::assertSame('Something New', $fixture[0]->getCompany());
        self::assertSame('Something New', $fixture[0]->getAddress());
        self::assertSame('Something New', $fixture[0]->getComplement());
        self::assertSame('Something New', $fixture[0]->getPhone());
        self::assertSame('Something New', $fixture[0]->getCity());
        self::assertSame('Something New', $fixture[0]->getCodepostal());
        self::assertSame('Something New', $fixture[0]->getCountry());
        self::assertSame('Something New', $fixture[0]->getUserAdress());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Adress();
        $fixture->setFullname('My Title');
        $fixture->setCompany('My Title');
        $fixture->setAddress('My Title');
        $fixture->setComplement('My Title');
        $fixture->setPhone('My Title');
        $fixture->setCity('My Title');
        $fixture->setCodepostal('My Title');
        $fixture->setCountry('My Title');
        $fixture->setUserAdress('My Title');

        $this->repository->save($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/adress/');
    }
}
