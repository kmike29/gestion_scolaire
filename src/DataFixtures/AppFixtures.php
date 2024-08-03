<?php

namespace App\DataFixtures;

use App\Entity\AnneeScolaire;
use App\Entity\Classe;
use App\Entity\ClasseAnneeScolaire;
use App\Entity\Niveau;
use App\Entity\Remise;
use App\Entity\TypeRemise;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $annéeScolaire = new AnneeScolaire();
        $annéeScolaire->setDebut(new \DateTime('10/10/2023'));
        $annéeScolaire->setFin(new \DateTime('10/06/2024'));
        $annéeScolaire->setActive(true);
        $annéeScolaire->setDesignation('2023-2024');
        $manager->persist($annéeScolaire);

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

        $classeSuperieure = null;

        $grades = array_reverse(['CP1', 'CP2', 'CE1', 'CE2', 'CM1', 'CM2']);
        foreach ($grades as $value) {
            $grade = new Classe();
            $grade->setNom($value);
            $grade->setNiveau($primaire);
            $grade->setFraisScolariteDeBase(10000);
            $grade->setFraisInscriptionDeBase(1000);
            $grade->setClasseSuperieure($classeSuperieure);
            $manager->persist($grade);

            $classeSuperieure = $grade;

            $gradeYear = new ClasseAnneeScolaire();
            $gradeYear->setAnneeScolaire($annéeScolaire) ;
            $gradeYear->setClasse($grade) ;
            $gradeYear->setFraisInscription($grade->getFraisInscriptionDeBase()) ;
            $gradeYear->setFraisScolarite($grade->getFraisScolariteDeBase()) ;
            $manager->persist($gradeYear);

        }

        $ps = array_reverse(['Petite section', 'Grades section']);
        foreach ($ps as $value) {
            $grade = new Classe();
            $grade->setNom($value);
            $grade->setNiveau($préscolaire);
            $grade->setFraisScolariteDeBase(5000);
            $grade->setFraisInscriptionDeBase(1000);
            $grade->setClasseSuperieure($classeSuperieure);
            $manager->persist($grade);

            $classeSuperieure = $grade;

            $gradeYear = new ClasseAnneeScolaire();
            $gradeYear->setAnneeScolaire($annéeScolaire) ;
            $gradeYear->setClasse($grade) ;
            $gradeYear->setFraisInscription($grade->getFraisInscriptionDeBase()) ;
            $gradeYear->setFraisScolarite($grade->getFraisScolariteDeBase()) ;
            $manager->persist($gradeYear);
        }

        $typeRemise = new TypeRemise();
        $typeRemise->setDesignation('nombres enfants');
        $manager->persist($typeRemise);

        $remise = new Remise();
        $remise->setDesignation('2 enfants');
        $remise->setPourcentage(20);
        $remise->setTypeRemise($typeRemise);
        $manager->persist($remise);





        $manager->flush();
    }
}
