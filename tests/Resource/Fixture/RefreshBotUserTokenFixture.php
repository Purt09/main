<?php

namespace App\Tests\Resource\Fixture;

use App\Tests\Tools\FakerTools;
use App\Tokens\Domain\Factory\RefreshBotUserTokenFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class RefreshBotUserTokenFixture extends Fixture
{
    use FakerTools;

    const REFERENCE = 'user';

    public function load(ObjectManager $manager)
    {
        $tg_id = $this->getFaker()->randomNumber();
        $first_name = $this->getFaker()->ipv4();
        $token = (new RefreshBotUserTokenFactory())->create($tg_id, $first_name);

        $manager->persist($token);
        $manager->flush();

        $this->addReference(self::REFERENCE, $token);
    }

}