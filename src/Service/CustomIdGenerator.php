<?php

namespace App\Service;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Id\AbstractIdGenerator;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\TransactionRequiredException;

class CustomIdGenerator extends AbstractIdGenerator
{
    /**
     * @param EntityManager $em
     * @param object|null $entity
     * @return string|null
     * @throws ORMException
     * @throws OptimisticLockException
     * @throws TransactionRequiredException
     */
    public function generate(EntityManager $em, $entity): ?string
    {
        $entityName = $em->getClassMetadata(get_class($entity))->getName();

        while (true) {
            $id = bin2hex(random_bytes(4));
            $item = $em->find($entityName, $id);

            if (!$item) {
                return $id;
            }
        }

        return null;
    }
}
