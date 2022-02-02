<?php

namespace App\Repository;

use App\Entity\Ad;
use App\Form\SearchAdCommand;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Ad|null find($id, $lockMode = null, $lockVersion = null)
 * @method Ad|null findOneBy(array $criteria, array $orderBy = null)
 * @method Ad[]    findAll()
 * @method Ad[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AdRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Ad::class);
    }

    public function search(SearchAdCommand $searchAdCommand, bool $returnResult = false)
    {
        $qb = $this->createQueryBuilder('a');

        if($searchAdCommand->getTitle()) {
            $qb->andWhere('a.title LIKE :title');
            $qb->setParameter('title', '%'.$searchAdCommand->getTitle().'%');
        }

        return $this->findAll() ? $qb->getQuery()->getResult() : $qb;
    }
}
