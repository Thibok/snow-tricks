<?php

/**
 * Comment Repository
 */

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * CommentRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CommentRepository extends EntityRepository
{
    public function getComments($trickId, $page, $nbPerPage)
    {
        $query = $this->createQueryBuilder('c')
            ->where('c.trick = :trickId')
            ->setParameter(':trickId', $trickId)
            ->innerJoin('c.user', 'u')
            ->addSelect('u')
            ->innerJoin('u.image', 'i')
            ->addSelect('i')
            ->orderBy('c.addAt', 'DESC')
            ->getQuery()
        ;

        $query
            ->setFirstResult(($page - 1) * $nbPerPage)
            ->setMaxResults($nbPerPage)
        ;

        return new Paginator($query, true);
    }
}
