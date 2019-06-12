<?php

namespace App\Service;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Id\AbstractIdGenerator;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\TransactionRequiredException;

class Generator extends AbstractIdGenerator
{
    /**
     * @param EntityManager $em
     * @param object|null $entity
     * @throws ORMException
     * @throws OptimisticLockException
     * @throws TransactionRequiredException
     * @return int
     */
    public function generate(EntityManager $em, $entity)
    {
        $entityName = $em->getClassMetadata(get_class($entity))->getName();

        while (true) {
            $id = mt_rand(100000, 999999);
            $item = $em->find($entityName, $id);

            if (!$item) {
                return $id;
            }
        }
    }
}