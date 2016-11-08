<?php

namespace TimeLogger\Model;

use RuntimeException;
use Doctrine\ORM\EntityManager;
use TimeLogger\Model\Project;
use TimeLogger\Model\TimeLog;

class ProjectTable
{
    private $entityManager;

    public function __construct(EntityManager $em)
    {
        $this->entityManager = $em;
    }

    public function fetchAll()
    {
        $projectRepository = $this->entityManager->getRepository('TimeLogger\Model\Project');
        return $projectRepository->findAll();
    }

    public function getProject($id)
    {
        $id = (int) $id;

        $project = $this->entityManager->find("TimeLogger\Model\Project", $id);

        if (! $project) {
            throw new RuntimeException(sprintf(
                'Could not find project with identifier %d', $id
            ));
        }

        return $project;
    }

    public function saveProject(Project $project)
    {
        $id = (int) $project->getId();

        if ($id === 0) {
            $this->entityManager->persist($project);
        }

        foreach ( $project->getTimeLogs() as $timelog){
            $this->entityManager->persist($timelog);
        }

        $this->entityManager->flush();
    }

    public function getProjectsOpenTimeLog(Project $project)
    {
        $id = (int) $project->getId();

        $dql = "SELECT t FROM TimeLogger\Model\TimeLog t JOIN t.project p WHERE t.finished IS NULL AND p.id = ?1";

        return $this->entityManager->createQuery($dql)
                             ->setParameter(1, $id)
                             ->getResult();
    }
}
