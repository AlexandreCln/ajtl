<?php

namespace App\DataFixtures;

use App\Entity\Partner;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class PartnerFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');

        for ($i = 0; $i < 5; $i++) {
            $partner = new Partner();
            $partner->setName(ucfirst($faker->word));
            $partner->setPresentation($faker->text(400));
            $partner->setLink($faker->url);
            $partner->setUpdatedAt(new DateTime());
            $partner->setFilenamePartner('');
            $manager->persist($partner);
        }

        $manager->flush();
    }
}
