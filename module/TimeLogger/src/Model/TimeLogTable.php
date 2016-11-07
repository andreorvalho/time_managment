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

    public function fetchAll()
    {
        $timeLogRepository = $this->entityManager->getRepository('TimeLogger\Model\TimeLog');
        return $timeLogRepository->findAll();
    }
}
