<?php

namespace App\DataFixtures;

use App\Entity\Classe;
use App\Entity\Niveau;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $levels = ['Préscolaire', 'Primaire'];
        foreach ($levels as $value) {
            $level = new Niveau();
            $level->setNom($value);
            if ('Préscolaire' == $value) {
                $préscolaire = $level;
            }
            if ('Primaire' == $value) {
                $primaire = $level;
            }
            $manager->persist($level);
        }
        $manager->flush();

        // To update
        $ps = ['Petite section', 'Grades section'];
        foreach ($ps as $value) {
            $grade = new Classe();
            $grade->setNom($value);
            $grade->setNiveau($préscolaire);
            $manager->persist($grade);

        }

        $grades = ['CP1', 'CP2', 'CE1', 'CE2', 'CM1', 'CM2'];
        foreach ($grades as $value) {
            $grade = new Classe();
            $grade->setNom($value);
            $grade->setNiveau($primaire);
            $manager->persist($grade);
        }

        $manager->flush();
    }
}
