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

    public function save(RefreshBotUserToken $token): void
    {
        $this->_em->persist($token);
    }

    public function add(RefreshBotUserToken $token): void
    {
        $this->_em->persist($token);
        $this->_em->flush();
    }

    public function remove(RefreshBotUserToken $token): void
    {
        $this->_em->remove($token);
        $this->_em->flush();
    }

    public function findByToken(string $token): ?RefreshBotUserToken
    {
        return $this->findOneBy(['token' => $token]);
    }
}
