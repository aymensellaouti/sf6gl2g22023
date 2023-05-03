<?php

namespace App\DataFixtures;

use App\Entity\Todo;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $todo = new Todo();
        $todo->setName("new Fake Todo");
        $todo->setContent("fake todo content");
        $manager->persist($todo);

        $manager->flush();
    }
}
