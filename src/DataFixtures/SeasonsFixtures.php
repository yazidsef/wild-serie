<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Season;
use Faker\Factory;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class SeasonsFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager): void
    {   
        $faker=Factory::create();
        for($i=0;$i<10;$i++){
           $season= new Season();
           $season->setNumber($faker->numberBetween(1,10));
           $season->setYear($faker->year());
           $season->setProgram($this->getReference('program_Arcane'.$i));
           $season->setDescription($faker->text());
           $this->addReference('season_'.$i,$season);
        $manager->persist($season);
            
        }

        $manager->flush();
    }
    public function getOrder(){
        return 1;
    }
    function getDependencies(){
        return [
            ProgramFixtures::class,
        ];
    }
}
