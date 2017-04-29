<?php

namespace ConferenceSchedulerBundle\Repository;

use Doctrine\ORM\EntityRepository;
use ConferenceSchedulerBundle\Entity\Conference;

/**
 * ConferenceProgramRepository
 */
class ConferenceProgramRepository extends EntityRepository {

    /**
     * Get query of conference program
     * 
     * @param \ConferenceSchedulerBundle\Entity\Conference $conference
     * @return \Doctrine\ORM\Query
     */
    public function findAllByConferenceQuery(Conference $conference) {
        $result = $this->createQueryBuilder('t')
                ->select('t, cl')
                ->leftJoin('t.lecturers', 'cl')
//                ->leftJoin('cl.user', 'u')
                ->where('t.conference = :conference')
                ->setParameter('conference', $conference)
                ->orderBy('t.start, t.name')
                ->getQuery()
        ;

        return $result;
    }

}
