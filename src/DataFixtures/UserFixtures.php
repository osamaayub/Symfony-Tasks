<?php

namespace App\DataFixtures;
use App\Entity\Profile;
use App\Entity\User;

use Doctrine\Bundle\FixturesBundle\Fixture;
use \Doctrine\Persistence\ObjectManager;



class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $user=new User();
        $user->setUsername('ahmed4395');
        $user->setPassword('test123');
        $user->setEmail('ahmed@gmail.com');

        $user1=new User();
        $user1->setUsername('ali123');
        $user1->setPassword('ali1234');
        $user1->setEmail('ali.hameed@gmail.com');

        $profile=$this->getReference('profile-1',Profile::class);
        $profil1=$this->getReference('profile-2',Profile::class);
        $user->setProfile($profile);
        $user1->setProfile($profil1);

        $manager->persist($user);
        $manager->flush();

    }
    public function getDependencies(): array
    {
        return [
            userFixtures::class,
        ];
    }
}


?>
