<?php

namespace App\Tokens\Infrastructure\Repository;

use App\Tokens\Domain\Entity\RefreshBotUserToken;
use App\Tokens\Domain\Repository\RefreshBotUserTokenRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class RefreshBotUserTokenRepository extends ServiceEntityRepository implements RefreshBotUserTokenRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RefreshBotUserToken::class);
    }

    public function add(RefreshBotUserToken $user): void
    {
        $this->_em->persist($user);
        $this->_em->flush();
    }

    public function findByToken(string $token): ?RefreshBotUserToken
    {
        return $this->findOneBy(['token' => $token]);
    }
}