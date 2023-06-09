<?php

namespace App\DataFixtures;

use App\Entity\Docteur;
use App\Entity\TypeConsultation;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
   
    {
        $this->hasher = $hasher;  
    }


    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        $user = new User();
        $user->setEmail("thibautfiquet7@gmail.com");
        $pass = $this->hasher->hashPassword($user, "thibaut");
        $user->setPassword($pass);
        $user->setNom("Fiquet");
        $user->setPrenom("Thibaut");
        $user->setTelephone("000000000");
        $manager->persist($user);
        $manager->flush();

        $doc = new Docteur();
        $doc->setNom("Dr thibaut");
        $doc->setTelephone("0000000000");
        $doc->setVille("Lille");
        $doc->setDescription("Bienvenue");
        $doc->setCompteUser($user);
        $manager->persist($doc);

        $typeConsultation = ['Medecin G', 'Psy', 'Kiné', 'Pediatre'];
        foreach ($typeConsultation as $t){
            $type = new TypeConsultation();
            $type->setLibelle($t);
            $type->setDuree(mt_rand(10,30));
            $manager->persist($type);
        }
        $manager->flush();
    }
}
