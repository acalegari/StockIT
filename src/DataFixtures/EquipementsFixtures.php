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
            //setCatefories id due to foreignKey of categories_id | ManyToOne => Equipements Many -> Categories 1
            $equipement->setCategories($this->getReference($value['idCategory']));
            $manager->persist($equipement);
        }
        
        $manager->flush();
    }
    
    //start the fixature using AppFixatures then EquiepementsFixatures due to relation between both tables 
    public function getDependencies()
    {
        return [
            AppFixtures::class  
        ];
    }
}
