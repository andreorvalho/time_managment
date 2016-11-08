<?php

namespace TimeLogger\Model;

use DomainException;
use Zend\Filter\ToInt;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;


/**
 * TimeLog
 */
class TimeLog
{
    /**
     * @var integer
     */
    protected $id;

    /**
     * @var \DateTime
     */
    protected $started;

    /**
     * @var \DateTime
     */
    protected $finished;

    /**
     * @var \TimeLogger\Model\Project
     */
    protected $project;

    private $inputFilter;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set started
     *
     * @param \DateTime $started
     *
     * @return TimeLog
     */
    public function setStarted($started)
    {
        $this->started = $started;

        return $this;
    }

    /**
     * Get started
     *
     * @return \DateTime
     */
    public function getStarted()
    {
        return $this->started;
    }

    /**
     * Set finished
     *
     * @param \DateTime $finished
     *
     * @return TimeLog
     */
    public function setFinished($finished)
    {
        $this->finished = $finished;

        return $this;
    }

    /**
     * Get finished
     *
     * @return \DateTime
     */
    public function getFinished()
    {
        return $this->finished;
    }

    /**
     * Set project
     *
     * @param \TimeLogger\Model\Project $project
     *
     * @return TimeLog
     */
    public function setProject(\TimeLogger\Model\Project $project = null)
    {
        $this->project = $project;

        return $this;
    }

    /**
     * Get project
     *
     * @return \TimeLogger\Model\Project
     */
    public function getProject()
    {
        return $this->project;
    }

    public function timeSpent()
    {
        if (!isset($this->finished)) {
            $finished = new \DateTime();
        }
        else{
            $finished = $this->finished;
        }
        $diff = $finished->diff($this->started);

        $hours = $diff->h;
        $hours = $hours + ($diff->days*24);
        return $hours;
    }

    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new DomainException(sprintf(
            '%s does not allow injection of an alternate input filter',
            __CLASS__
        ));
    }

    public function getInputFilter()
    {
        if ($this->inputFilter) {
            return $this->inputFilter;
        }

        $inputFilter = new InputFilter();

        $inputFilter->add([
            'name' => 'id',
            'required' => true,
            'filters' => [
                ['name' => ToInt::class],
            ],
        ]);

        $inputFilter->add([
            'name' => 'started',
            'required' => true,
        ]);

        $inputFilter->add([
            'name' => 'finished',
            'required' => true,
        ]);

        $this->inputFilter = $inputFilter;
        return $this->inputFilter;
    }

    public function exchangeArray(array $data)
    {
        $this->id = $data['id'];
        $this->started = $data['started'];
        $this->finished = $data['finished'];
    }

    /**
     * Convert the object to an array.
     *
     * @return array
     */
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
}

