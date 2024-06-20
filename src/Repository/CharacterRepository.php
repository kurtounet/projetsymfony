<?php

namespace App\Repository;

use App\Entity\Character;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Character>
 */
class CharacterRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Character::class);
    }
    public function findCharactersByFilters(array $filters)
    {

        $qb = $this->createQueryBuilder('c');
        // si le tableau n'est pas vide $filters['name']
        if (!empty($filters['name'])) {
            $qb->andWhere('c.name LIKE :name')
                ->setParameter('name', '%' . $filters['name'] . '%');
        }

        if (!empty($filters['race'])) {
            $qb->andWhere('c.race = :race')
                ->setParameter('race', $filters['race']);
        }

        if (!empty($filters['affiliation'])) {
            $qb->andWhere('c.affiliation = :affiliation')
                ->setParameter('affiliation', $filters['affiliation']);
        }

        if (!empty($filters['gender'])) {
            $qb->andWhere('c.gender = :gender')
                ->setParameter('gender', $filters['gender']);
        }

        if (!empty($filters['planet'])) {
            $qb->andWhere('c.planet = :planet')
                ->setParameter('planet', $filters['planet']);
        }
        $result = $qb->getQuery()->getResult();
        //dd($result);
        return $result;
    }

    //    /**
    //     * @return Character[] Returns an array of Character objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('c.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Character
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
