<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Equipements;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class EquipementsFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $jsonEquipements = 'public\assets\js\equipements.json';
        $equipements =  file_get_contents($jsonEquipements,false);
        $equipementsData = json_decode($equipements,true);
        foreach ($equipementsData as $value) {

            $equipement = new Equipements();
            $equipement->setName($value['name']);
            $equipement->setCanBeLoaned($value['canBeLoaned']);
            $equipement->setImage($value['imageUrl']);
            $equipement->setCategories($this->getReference($value['idCategory']));
            $manager->persist($equipement);
        }
        
        $manager->flush();
    }
    
    public function getDependencies()
    {
        return [
            AppFixtures::class  
        ];
    }
}
