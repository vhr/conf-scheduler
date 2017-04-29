<?php

namespace ConferenceSchedulerBundle\Repository;

use Doctrine\ORM\EntityRepository;
use ConferenceSchedulerBundle\Entity\Conference;

/**
 * UserRepository
 */
class UserRepository extends EntityRepository {

    /**
     * Find all administrators who are not in specific conference
     * 
     * @param Conference $conference
     * @return \Doctrine\ORM\Query
     */
    public function findAdminsWithoutConferenceQuery(Conference $conference) {
        $result = $this->createQueryBuilder('t')
                ->leftJoin('ConferenceSchedulerBundle:ConferenceAdmin', 'ca', 'WITH', 't.id = ca.user')
                ->where('ca.id IS NULL OR ca.conference <> :conference')
                ->setParameter('conference', $conference)
                ->orderBy('t.name')
                ->getQuery()
        ;

        return $result;
    }

    /**
     * Find all users who are not in invited for lecturers in conference
     * 
     * @param Conference $conference
     * @return \Doctrine\ORM\Query
     */
    public function findNotLecturerInConferenceQuery(Conference $conference) {
        $result = $this->createQueryBuilder('t')
                ->leftJoin('ConferenceSchedulerBundle:ConferenceLecturer', 'cl', 'WITH', 't.id = cl.user')
                ->where('cl.id IS NULL OR cl.conference <> :conference')
                ->setParameter('conference', $conference)
                ->orderBy('t.name')
                ->getQuery()
        ;

        return $result;
    }

    /**
     * Find all administrators who are not in specific conference
     * 
     * @param Conference $conference
     * @return array
     */
    public function findAdminsWithoutConference(Conference $conference) {
        $result = $this->findAdminsWithoutConferenceQuery($conference)
                ->getResult()
        ;
    }

    /**
     * Find all users who are not in invited for lecturers in conference
     * 
     * @param Conference $conference
     * @return array
     */
    public function findNotLecturerInConference(Conference $conference) {
        $result = $this->findNotLecturerInConferenceQuery($conference)
                ->getResult()
        ;

        return $result;
    }

    /**
     * Find all users who are not in invited for lecturers and not join as users to conference
     * 
     * @param Conference $conference
     * @return array
     */
    public function findNotUserOrLecturerInConference(Conference $conference) {
        $result = $this->createQueryBuilder('t')
                ->leftJoin('ConferenceSchedulerBundle:ConferenceLecturer', 'cl', 'WITH', 't.id = cl.user')
                ->leftJoin('ConferenceSchedulerBundle:ConferenceUser', 'cu', 'WITH', 't.id = cu.user')
                ->where('cl.id IS NULL AND cu.id IS NULL')
                ->getQuery()
                ->getResult()
        ;

        return $result;
    }

}
