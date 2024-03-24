<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Episode;
use Faker\Factory;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class EpisodesFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker= Factory::create();
        for($i=0 ; $i<10 ; $i++){
        $episode=new Episode();
        $episode->setTitle($faker->word());
        $episode->setNumber($faker->numberBetween(1,10));
        $episode->setSynopsis($faker->paragraphs(3,true));
        $episode->setSeason($this->getReference('season_'.$i));
        $manager->persist($episode);
        
        }
        $manager->flush();
    }
    public function getOrder(){
        return 2;
    }
    function getDependencies(){
        return [
            SeasonsFixtures::class,
        ];
    }
}
