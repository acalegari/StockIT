<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Categories;

class AppFixtures extends Fixture 
{
    public function load(ObjectManager $manager): void
    {
       
        $jsonCategories = 'public\assets\js\categories.json';
        $categories =  file_get_contents($jsonCategories,false);
        $categoriesData = json_decode($categories,true);
        foreach ($categoriesData as $value) {
            $category = new Categories();
            $category->setName($value['name']);
            $this->addReference($value['id'], $category);
            $manager->persist($category);
        }
        $manager->flush();
    }
}
