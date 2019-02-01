<?php

namespace App\Repository;

use App\Entity\Visit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Visit|null find($id, $lockMode = null, $lockVersion = null)
 * @method Visit|null findOneBy(array $criteria, array $orderBy = null)
 * @method Visit[]    findAll()
 * @method Visit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VisitRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Visit::class);
    }

    public function findDeviceRepartition()
    {
        $qb = $this->createQueryBuilder('visit');

        return $qb
            ->select('visit.device', $qb->expr()->count('visit') . 'as count')
            ->groupBy('visit.device')
            ->getQuery()
            ->getResult();
    }

    public function findLanguageRepartition()
    {
        $qb = $this->createQueryBuilder('visit');

        return $qb
            ->select('visit.language', $qb->expr()->count('visit') . 'as count')
            ->groupBy('visit.language')
            ->getQuery()
            ->getResult();
    }

    public function findTopUrl()
    {
        $qb = $this->createQueryBuilder('visit');
        $qb
            ->select(
                'visit.action',
                $qb->expr()->count('visit') . 'as count',
                $qb->expr()->concat(
                    'DATE_PART(\'year\', visit.occurredAt)',
                    '\'-\'',
                    'DATE_PART(\'month\', visit.occurredAt)',
                    '\'-\'',
                    'DATE_PART(\'day\', visit.occurredAt)',
                    '\' \'',
                    'DATE_PART(\'hour\', visit.occurredAt)'
                ) . ' as hour')
            ->where($qb->expr()->eq('visit.type', '?0'))
            ->setParameter(0, 'page')
            ->groupBy('visit.action', 'hour');

        return $qb->getQuery()->getResult();
    }

    // /**
    //  * @return Visit[] Returns an array of Visit objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('v.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Visit
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
