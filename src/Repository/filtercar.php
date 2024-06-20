// src/Repository/CharacterRepository.php

public function findCharactersByFilters(array $filters)
{
    $qb = $this->createQueryBuilder('c');

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

    return $qb