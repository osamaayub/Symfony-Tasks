<?php 

namespace App\DataFixtures;

use App\Entity\Profile;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;


class ProfileFixtures extends Fixture{
    public function load(ObjectManager $manager): void{
        $profile=new Profile();
        $profile->setFirstname('ahmed');
        $profile->setLastname('jamal');

        $profile1=new Profile();
        $profile1->setFirstname('ali');
        $profile1->setLastname('hameed');
        $manager->persist($profile);
        $manager->flush();
        $this->addReference('profile-1',$profile);
        $this->addReference('profile-2',$profile1);
    }
    public function getDependencies(): array
    {
        return [
          userFixtures::class,
        ];
    }
}


?>