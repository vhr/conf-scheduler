<?php

namespace ConferenceSchedulerBundle\Repository;

use Doctrine\ORM\EntityRepository;
use ConferenceSchedulerBundle\Entity\ConferenceProgram;
use ConferenceSchedulerBundle\Entity\ConferenceLecturer;

/**
 * CurriculumLecturerRepository
 */
class ConferenceLecturerRepository extends EntityRepository {

    /**
     * Find all active lectures in conference
     * 
     * @param ConferenceProgram $program
     * @return \Doctrine\ORM\Query
     */
    public function findLecturerInConferenceQuery(ConferenceProgram $program) {
        $result = $this->createQueryBuilder('t')
                ->select('t, u')
                ->innerJoin('t.user', 'u')
                ->leftJoin('ConferenceSchedulerBundle:ConferenceProgramLecturer', 'cpl', 'WITH', 'u.id = cpl.user')
                ->where('t.conference = :conference AND t.status = :status AND (cpl.id IS NULL OR cpl.program <> :program)')
                ->setParameter('conference', $program->getConference())
                ->setParameter('program', $program)
                ->setParameter('status', ConferenceLecturer::STATUS_ACTIVE)
                ->orderBy('u.name')
                ->getQuery()
        ;

        return $result;
    }

}
