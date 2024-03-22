<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Program;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker\Factory;
class ProgramFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker=Factory::create();

        for($i=0;$i<10;$i++){
        $program=new Program();
        $program->setTitle($faker->word());
        $program->setSynopsis($faker->paragraphs(3,true));
        $program->setCategory($this->getReference('category_Action'));
        $manager->persist($program);
        $manager->flush();
        }
        
    }

    public function getDependencies(){
        // tu retournes ici les classes de fixtures dont ProgramFixtures dépend 
        return [
            CategoryFixtures::class,
        ];
    }
}
