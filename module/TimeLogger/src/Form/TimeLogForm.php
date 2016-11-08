<?php

namespace TimeLogger\Form;

use Zend\Form\Form;
use Zend\Form\Element\DateTime;

class TimeLogForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('project');

        $this->add([
            'name' => 'id',
            'type' => 'hidden',
        ]);

        $this->add([
            'name' => 'started',
            'type' => 'DateTime',
            'attributes' => [
                'id' => 'time_log_started',
                'class' => 'required form-control',
                'type' => 'text',
                'data-format' => "dd/MM/yyyy hh:mm:ss",
                'placeholder' => 'Started'
            ],
            'options' => [
                'label' => 'Started'
            ]
        ]);

        $this->add([
            'name' => 'finished',
            'type' => 'DateTime',
            'attributes' => [
                'id' => 'time_log_finished',
                'class' => 'required form-control',
                'type' => 'text',
                'data-format' => "dd/MM/yyyy hh:mm:ss",
                'placeholder' => 'Finished'
            ],
            'options' => [
                'label' => 'Finished'
            ]
        ]);

        $this->add([
            'name' => 'submit',
            'type' => 'submit',
            'attributes' => [
                'value' => 'Go',
                'id'    => 'submitbutton',
                'class' => 'btn btn-primary'
            ],
        ]);
    }
}
