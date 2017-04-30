<?php

namespace ConferenceSchedulerBundle\Repository;

use Doctrine\ORM\EntityRepository;
use ConferenceSchedulerBundle\Entity\User;
use DateTime;

/**
 * CurriculumRepository
 */
class ConferenceRepository extends EntityRepository {

    /**
     * Find all conferences for user
     * 
     * @param User $user
     * @return \Doctrine\ORM\Query
     */
    public function findAllByAccessQuery(User $user = null) {
        $result = $this->createQueryBuilder('t')
                ->where('t.date IS NULL OR t.date >= :now')
                ->setParameter('now', new DateTime)
                ->orderBy('t.date', 'ASC')
                ->getQuery()
        ;

        return $result;
    }

}
