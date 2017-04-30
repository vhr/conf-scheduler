<?php

namespace ConferenceSchedulerBundle\Repository;

use Doctrine\ORM\EntityRepository;
use ConferenceSchedulerBundle\Entity\User;

/**
 * VenueRepository
 */
class VenueRepository extends EntityRepository {

    /**
     * Find all conferences for user
     * 
     * @param User $user
     * @return \Doctrine\ORM\Query
     */
    public function findAllByAccessQuery(User $user = null) {
        $result = $this->createQueryBuilder('t')
                ->orderBy('t.name', 'ASC')
                ->getQuery()
        ;

        return $result;
    }

}
