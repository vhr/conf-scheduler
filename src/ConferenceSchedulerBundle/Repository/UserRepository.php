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
     * @return array
     */
    public function findAdminsWithoutConference(Conference $conference) {
        $list = [];

        foreach ($conference->getAdmins() as $admin) {
            $list[] = $admin->getId();
        }

        $query = $this->createQueryBuilder('t')
                ->where('t.roles LIKE :role_admin')
                ->setParameter('role_admin', '%ROLE_ADMIN%');

        if ($list) {
            $query = $query->andWhere('t.id NOT IN (:list)')
                    ->setParameter('list', $list);
        }

        $result = $query->getQuery()
                ->getResult();

        return $result;
    }

}
