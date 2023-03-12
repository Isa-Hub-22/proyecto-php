<?php

namespace App\DataFixtures;

use App\Entity\RickAndMorty;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Faker\Factory;    
use Doctrine\Persistence\ObjectManager;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class RickAndMortyFixture extends Fixture
{
    protected $client;
    public function __construct(HttpClientInterface $client)
    {
       $this -> client = $client;     
    }
    public function load(ObjectManager $manager): void
    {
       $faker = Factory::create();
       for ($i=0; $i<100; $i++){
        $rickandmorty = new RickAndMorty();
        $rickandmorty->setNombre($faker->word());
        $rickandmorty->setDescripcion($faker->text(100));
        $numRickandmorty = $faker -> numberBetween(1,200);
        $rickandmorty->setImagen("https://rickandmortyapi.com/api/character/avatar/$numRickandmorty.jpeg");
        $rickandmorty->setCodigo($numRickandmorty);
        $manager->persist($rickandmorty);
       }
       for ($i=0; $i<10; $i++){
        $numRickandmorty = $faker -> numberBetween(1,200);
        $response = $this->client->request(
            'GET',
            "https://rickandmortyapi.com/api/character/$numRickandmorty/"
        );
        $contenido = $response->toArray();
        $rickandmorty = new RickAndMorty();
        $rickandmorty->setNombre($contenido['name']);
        $rickandmorty->setDescripcion($faker->text(100));
        $rickandmorty->setImagen("https://rickandmortyapi.com/api/character/avatar/$numRickandmorty.jpeg");
        $rickandmorty->setCodigo($numRickandmorty);
        $manager->persist($rickandmorty);
       }

        $manager->flush();
    }
     }
