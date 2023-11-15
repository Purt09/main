<?php

namespace App\Tests\Resource\Fixture;

use App\Tests\Tools\FakerTools;
use App\Tokens\Domain\Factory\RefreshBotUserTokenFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class RefreshBotUserTokenFixture extends Fixture
{
    use FakerTools;

    public const REFERENCE = 'BotUserToken';
    public const REFERENCE_TIME_OUT = 'BotUserTokenTimeOut';
    public const REFERENCE_REFRESH = 'BotUserTokenRefresh';

    public function load(ObjectManager $manager)
    {
        $tg_id = $this->getFaker()->randomNumber();
        $bot_id = $this->getFaker()->randomNumber();
        $ip = $this->getFaker()->ipv4();
        $userAgent = $this->getFaker()->userAgent();

        $token = (new RefreshBotUserTokenFactory())->create($tg_id, $bot_id, $ip, $userAgent);
        $tokenOut = (new RefreshBotUserTokenFactory())->create($tg_id, $bot_id, $ip, $userAgent, time() - intval($_ENV['REFRESH_TOKEN_DAYS_LIFE']) * 24 * 60 * 60 - 1);
        $tokenRefresh = (new RefreshBotUserTokenFactory())->create($tg_id, $bot_id, $ip, $userAgent);
        $tokenRefresh->setRefreshAt(time());

        $manager->persist($token);
        $manager->persist($tokenOut);
        $manager->persist($tokenRefresh);
        $manager->flush();

        $this->addReference(self::REFERENCE, $token);
        $this->addReference(self::REFERENCE_TIME_OUT, $tokenOut);
        $this->addReference(self::REFERENCE_REFRESH, $tokenRefresh);
    }
}
