<?php

namespace App\Repository;

use App\Entity\dti\Chamado;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Chamado|null find($id, $lockMode = null, $lockVersion = null)
 * @method Chamado|null findOneBy(array $criteria, array $orderBy = null)
 * @method Chamado[]    findAll()
 * @method Chamado[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ChamadoRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Chamado::class);
    }

    /*
    public function findBySomething($value)
    {
        return $this->createQueryBuilder('c')
            ->where('c.something = :value')->setParameter('value', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */
}
