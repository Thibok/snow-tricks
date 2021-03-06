<?php

/**
 * User Repository
 */

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * UserRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class UserRepository extends EntityRepository
{
    /**
     * Get inactive Users
     * @access public
     * @param \DateTime $date
     * 
     * @return array
     */
    public function getInactiveUsers(\DateTime $date)
    {
        return $this->createQueryBuilder('u')
            ->where('u.isActive = 0')
            ->andWhere('u.registrationDate <= :date')
            ->setParameter('date', $date)
            ->andWhere('u.isActive = 0')
            ->innerJoin('u.image', 'img')
            ->addSelect('img')
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * Get if user exists
     * @access public
     * @param string $username
     * 
     * @return boolean
     */
    public function getUserExists($username)
    {
        $result = $this->createQueryBuilder('u')
            ->select('count(u.id)')
            ->where('u.username = :username')
            ->setParameter(':username', $username)
            ->andWhere('u.isActive = 1')
            ->getQuery()
            ->getSingleScalarResult()
        ;
        
        if ($result == 1) {
            return true;
        } else {
            return false;
        }      
    }
}
