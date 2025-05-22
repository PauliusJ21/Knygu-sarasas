<?php

namespace App\DataFixtures;

use App\Entity\Knyga;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class BookFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $books = [
            [
                'pavadinimas' => 'To Kill a Mockingbird',
                'autorius' => 'Harper Lee',
                'isleidimoMetai' => 1960,
                'isbnNumeris' => '9780061120084',
            ],
            [
                'pavadinimas' => '1984',
                'autorius' => 'George Orwell',
                'isleidimoMetai' => 1949,
                'isbnNumeris' => '9780451524935',
            ],
            [
                'pavadinimas' => 'Pride and Prejudice',
                'autorius' => 'Jane Austen',
                'isleidimoMetai' => 1813,
                'isbnNumeris' => '9781503290563',
            ],
            [
                'pavadinimas' => 'The Great Gatsby',
                'autorius' => 'F. Scott Fitzgerald',
                'isleidimoMetai' => 1925,
                'isbnNumeris' => '9780743273565',
            ],
            [
                'pavadinimas' => 'Moby-Dick',
                'autorius' => 'Herman Melville',
                'isleidimoMetai' => 1851,
                'isbnNumeris' => '9781503280786',
            ],
        ];

        foreach ($books as $data) {
            $book = new Knyga();
            $book->setPavadinimas($data['pavadinimas']);
            $book->setAutorius($data['autorius']);
            $book->setIsleidimoMetai($data['isleidimoMetai']);
            $book->setIsbnNumeris($data['isbnNumeris']);

            $manager->persist($book);
        }

        $manager->flush();
    }
}

