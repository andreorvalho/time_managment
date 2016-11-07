<?php

namespace TimeLogger\Model;

use RuntimeException;
use Doctrine\ORM\EntityManager;
use TimeLogger\Model\Project;

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

    public function saveProject(Project $project)
    {
        $id = (int) $project->getId();

        if ($id === 0) {
            $this->entityManager->persist($project);
        }

        $this->entityManager->flush();
    }
}
