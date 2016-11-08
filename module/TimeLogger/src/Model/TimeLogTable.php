<?php

namespace TimeLogger\Model;

use RuntimeException;
use Doctrine\ORM\EntityManager;
use TimeLogger\Model\TimeLog;

class TimeLogTable
{
    private $entityManager;

    public function __construct(EntityManager $em)
    {
        $this->entityManager = $em;
    }

    public function saveTimeLog(TimeLog $timeLog)
    {
        $id = (int) $timeLog->getId();

        if ($id === 0) {
            $this->entityManager->persist($timeLog);
        }

        $this->entityManager->flush();
    }

    public function saveTimeLog(TimeLog $timeLog)
    {
        $id = (int) $timeLog->getId();

        if ($id === 0) {
            $this->entityManager->persist($timeLog);
        }

        $this->entityManager->flush();
    }
}
