<?php

namespace TimeLogger\Form;

use Zend\Form\Form;

class ProjectForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('project');

        $this->setAttribute('class', 'form-inline');

        $this->add([
            'name' => 'id',
            'type' => 'hidden',
        ]);

        $this->add([
            'name' => 'name',
            'type' => 'text',
            'options' => [
                'label' => 'Name:',
            ],
            'attributes' => [
                'placeholder' => 'Name',
                'class' => 'form-control',
            ],
        ]);

        $this->add([
            'name' => 'submit',
            'type' => 'submit',
            'attributes' => [
                'value' => 'Add Project',
                'id'    => 'submitbutton',
                'class' => 'btn btn-primary',
            ],
        ]);
    }
}
