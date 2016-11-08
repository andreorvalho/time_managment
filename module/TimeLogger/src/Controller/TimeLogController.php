<?php

namespace TimeLogger\Controller;

use TimeLogger\Model\TimeLogTable;
use TimeLogger\Model\ProjectTable;
use TimeLogger\Model\TimeLog;
use TimeLogger\Form\TimeLogForm;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class TimeLogController extends AbstractActionController
{
    private $table;
    private $projectTable;

    public function __construct(TimeLogTable $table, ProjectTable $projectTable)
    {
        $this->table = $table;
        $this->projectTable = $projectTable;
    }

    public function indexAction()
    {
        $projectId = (int) $this->params()->fromRoute('project_id', 0);

        if (!$projectId) {
            return $this->redirect()->toRoute('projects');
        }

        $project = $this->projectTable->getProject($projectId);

        return new ViewModel([
            'timelogs' => $project->getTimeLogs(),
            'project'   => $project,
            'project_name' => $project->getName()
        ]);
    }

    public function newAction()
    {
        $form = new TimeLogForm();
        $form->get('submit')->setValue('Add');

        return new ViewModel([
            'form' => $form,
        ]);
    }

}
