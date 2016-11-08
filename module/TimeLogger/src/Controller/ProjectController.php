<?php

namespace TimeLogger\Controller;

use TimeLogger\Model\ProjectTable;
use TimeLogger\Model\Project;
use TimeLogger\Form\ProjectForm;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class ProjectController extends AbstractActionController
{
    private $table;

    public function __construct(ProjectTable $table)
    {
        $this->table = $table;
    }

    public function indexAction()
    {
        $form = new ProjectForm();

        return new ViewModel([
            'projects' => $this->table->fetchAll(),
            'form' => $form,
        ]);
    }

    public function createAction()
    {
        $form = new ProjectForm();
        $form->get('submit')->setValue('Add');

        $request = $this->getRequest();

        $project = new Project();
        $form->setInputFilter($project->getInputFilter());
        $form->setData($request->getPost());

        if (! $form->isValid()) {
            return ['form' => $form];
        }

        $project->exchangeArray($form->getData());
        $this->table->saveProject($project);
        return $this->redirect()->toRoute('projects');
    }

}
