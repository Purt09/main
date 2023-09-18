<?php

namespace App\Tests\Resource\Fixture;

use App\Tests\Tools\FakerTools;
use App\Users\Domain\Entity\UserType;
use App\Users\Domain\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixture extends Fixture
{
    use FakerTools;

    const REFERENCE = 'user';

    public function load(ObjectManager $manager)
    {
        $tg_id = $this->getFaker()->randomNumber();
        $first_name = $this->getFaker()->word();
        $last_name = $this->getFaker()->word();
        $username = $this->getFaker()->word();
        $type = $this->getFaker()->randomElement([
            UserType::PRIVATE,
            UserType::GROUP,
            UserType::SUPERGROUP,
            UserType::CHANNEL,
        ]);
        $user = (new UserFactory())->create($tg_id, $first_name, $last_name, $username, $type);

        $manager->persist($user);
        $manager->flush();

        $this->addReference(self::REFERENCE, $user);
    }
}