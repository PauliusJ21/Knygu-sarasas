<?php

namespace App\Tests\Controller;

use App\Entity\Knyga;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class KnygaControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $knygaRepository;
    private string $path = '/knyga/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->knygaRepository = $this->manager->getRepository(Knyga::class);

        foreach ($this->knygaRepository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $this->client->followRedirects();
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Knyga index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'knyga[pavadinimas]' => 'Testing',
            'knyga[autorius]' => 'Testing',
            'knyga[isleidimoMetai]' => 'Testing',
            'knyga[isbnNumeris]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->knygaRepository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Knyga();
        $fixture->setPavadinimas('My Title');
        $fixture->setAutorius('My Title');
        $fixture->setIsleidimoMetai('My Title');
        $fixture->setIsbnNumeris('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Knyga');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Knyga();
        $fixture->setPavadinimas('Value');
        $fixture->setAutorius('Value');
        $fixture->setIsleidimoMetai('Value');
        $fixture->setIsbnNumeris('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'knyga[pavadinimas]' => 'Something New',
            'knyga[autorius]' => 'Something New',
            'knyga[isleidimoMetai]' => 'Something New',
            'knyga[isbnNumeris]' => 'Something New',
        ]);

        self::assertResponseRedirects('/knyga/');

        $fixture = $this->knygaRepository->findAll();

        self::assertSame('Something New', $fixture[0]->getPavadinimas());
        self::assertSame('Something New', $fixture[0]->getAutorius());
        self::assertSame('Something New', $fixture[0]->getIsleidimoMetai());
        self::assertSame('Something New', $fixture[0]->getIsbnNumeris());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Knyga();
        $fixture->setPavadinimas('Value');
        $fixture->setAutorius('Value');
        $fixture->setIsleidimoMetai('Value');
        $fixture->setIsbnNumeris('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/knyga/');
        self::assertSame(0, $this->knygaRepository->count([]));
    }
}
