<?php

namespace TimeLogger\Controller;

use TimeLogger\Model\ProjectTable;
use TimeLogger\Model\Project;
use TimeLogger\Model\TimeLog;
use TimeLogger\Form\ProjectForm;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Debug\Debug;

class ProjectController extends AbstractActionController
{
    private $table;

    public function __construct(ProjectTable $table)
    {
        $this->table = $table;
    }

    public function indexAction()
    {
        return new ViewModel([
            'projects' => $this->table->fetchAll(),
            'form' => new ProjectForm(),
        ]);
    }

    public function createAction()
    {
        $form = new ProjectForm();
        $request = $this->getRequest();
        $project = new Project();

        $form->setInputFilter($project->getInputFilter());
        $form->setData($request->getPost());

        if (! $form->isValid()) {
            $view = new ViewModel([
                'projects' => $this->table->fetchAll(),
                'form' => $form,
            ]);

            $view->setTemplate('time-logger/project/index');
            return $view;
        }

        $project->exchangeArray($form->getData());
        $this->table->saveProject($project);
        return $this->redirect()->toRoute('projects');
    }

    public function updateAction(){
        $project = $this->getProject();
        $timelogs = $this->table->getProjectsOpenTimeLog($project);
        if (empty($timelogs)){
            $timelog = new TimeLog();
            $date = new \DateTime();

            $timelog->exchangeArray(['id' => 0, 'started' => $date, 'finished' => NULL]);
            $timelog->setProject($project);
            $project->addTimeLog($timelog);
            $this->table->saveProject($project);
        }
        else{
            foreach ($timelogs as $timelog){
                $date = new \DateTime();
                $timelog->exchangeArray(['id' => $timelog->getId(), 'started' => $timelog->getStarted(), 'finished' => $date]);
                $this->table->saveProject($project);
            }
        }
        return $this->redirect()->toRoute('projects');
    }

    private function getProject()
    {
        $projectId = (int) $this->params()->fromRoute('project_id', 0);
        return $this->table->getProject($projectId);
    }
}
