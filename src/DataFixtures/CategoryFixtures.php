<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Category;
class CategoryFixtures extends Fixture
{
    const CATEGORIES=['Action','aventure','animation','fantastique','horreur'];
    public function load(ObjectManager $manager): void
    {
        $category=new Category();
        foreach(self::CATEGORIES as $key=>$categoryname){
            $category=new category();
            $category->setName($categoryname);
            $manager->persist($category);
            //on ajoutant ici des references on pourra les utiliser dans les autres fixtures
            $this->addReference('category_'.$categoryname,$category);
        }
        $manager->flush();
    }
}
