<?php

namespace App\Repository;

use App\Entity\Visit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
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
            ->where($qb->expr()->gte('visit.occurredAt', '?0'))
            ->setParameter(0, date_create('yesterday'))
            ->getQuery()
            ->getResult();
    }

    public function findLanguageRepartition()
    {
        $qb = $this->createQueryBuilder('visit');

        $results = $qb
            ->select('visit.language', $qb->expr()->count('visit') . 'as count')
            ->groupBy('visit.language')
            ->where($qb->expr()->gte('visit.occurredAt', '?0'))
            ->setParameter(0, date_create('yesterday'))
            ->getQuery()
            ->getResult();

        return array_map(function ($result) {
            if ($result['language'] !== null) {
                $result['language'] = locale_get_display_language($result['language']);
            } else {
                $result['language'] = 'Unknown';
            }
            return $result;
        }, $results);
    }

    public function findTopUrl()
    {
        $qb = $this->createQueryBuilder('visit');
        $qb
            ->select(
                'visit.fullAction as action',
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
            ->innerJoin('App\Entity\Visit', 'today', Join::WITH, $qb->expr()->eq('today.id', 'visit.id'))
            ->andWhere($qb->expr()->gte('today.occurredAt', '?1'))
            ->setParameter(1, date_create('yesterday'))
            ->setParameter(0, 'page')
            ->orderBy('count', 'asc')
            ->groupBy('action', 'hour');

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
