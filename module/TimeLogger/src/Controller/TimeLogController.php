<?php

namespace TimeLogger\Controller;

use TimeLogger\Model\TimeLogTable;
use TimeLogger\Model\ProjectTable;
use TimeLogger\Model\TimeLog;
use TimeLogger\Form\TimeLogForm;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Debug\Debug;

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

    public function createAction()
    {
        $projectId = (int) $this->params()->fromRoute('project_id', 0);

        if (!$projectId) {
            return $this->redirect()->toRoute('projects');
        }

        $project = $this->projectTable->getProject($projectId);

        $form = new TimeLogForm();
        $form->get('submit')->setValue('Add');

        $request = $this->getRequest();

        $timelog = new TimeLog();

        $form->setInputFilter($timelog->getInputFilter());

        $postData = $request->getPost();
        $postData["started"] = \DateTime::createFromFormat('m/d/Y H:i A', $postData["started"]);
        $postData["finished"] = \DateTime::createFromFormat('m/d/Y H:i A', $postData["finished"]);

        $form->setData($postData);

        if (! $form->isValid()) {
            $view = new ViewModel([
                'project'   => $project,
                'form' => $form,
            ]);
            $view->setTemplate('time-logger/time-log/new');
            return $view;
        }

        $timelog->setProject($project);

        $timelog->exchangeArray($form->getData());
        $this->table->saveTimeLog($timelog);
        return $this->redirect()->toRoute('projects');
    }

    public function newAction()
    {
        $projectId = (int) $this->params()->fromRoute('project_id', 0);

        if (!$projectId) {
            return $this->redirect()->toRoute('projects');
        }

        $project = $this->projectTable->getProject($projectId);

        $form = new TimeLogForm();
        $form->get('submit')->setValue('Add');

        return new ViewModel([
            'project'   => $project,
            'form' => $form,
        ]);
    }

}
