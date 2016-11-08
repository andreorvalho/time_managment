<?php

namespace TimeLogger\Model;

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
        $diff = $this->finished->diff($this->started);

        $hours = $diff->h;
        $hours = $hours + ($diff->days*24);
        return $hours;
    }
}

