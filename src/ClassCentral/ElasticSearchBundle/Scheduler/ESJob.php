<?php
/**
 * Created by PhpStorm.
 * User: dhawal
 * Date: 4/18/14
 * Time: 8:57 PM
 */

namespace ClassCentral\ElasticSearchBundle\Scheduler;

/**
 *  Job definition
 * Class ESJob
 * @package ClassCentral\ElasticSearchBundle\Scheduler
 */
class ESJob {

    private $id;

    private $userId;

    /**
     * Job type
     * @var
     */
    private $jobType;

    /**
     *
     * When the job was created
     * @var \DateTime
     */
    private $created;


    /**
     * Format - YYYY-MM-dd; Y-m-d in php
     * Date to be run at
     * @var
     */
    private $runDate;

    /**
     * The class that will handle the job
     * @var
     */
    private $class;


    /**
     * Arguments for the job
     * @var
     */
    private $args;

    /**
     * Jobs can be split into groups to run in parallel based on splitId
     * @var
     */
    private $splitId;


    public function __construct( $id )
    {
       $this->created = new \DateTime();
       $this->id = $id;
    }

    /**
     * @param mixed $args
     */
    public function setArgs($args)
    {
        $this->args = $args;
    }

    /**
     * @return mixed
     */
    public function getArgs()
    {
        return $this->args;
    }

    /**
     * @param mixed $class
     */
    public function setClass($class)
    {
        $this->class = $class;
    }

    /**
     * @return mixed
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * @param \DateTime $created
     */
    public function setCreated( \DateTime $created)
    {
        $this->created = $created;
    }

    /**
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $runDate
     */
    public function setRunDate($runDate)
    {
        $this->runDate = $runDate;
    }

    /**
     * @return mixed
     */
    public function getRunDate()
    {
        return $this->runDate;
    }

    /**
     * @param mixed $type
     */
    public function setJobType($type)
    {
        $this->jobType = $type;
    }

    /**
     * @param mixed $userId
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @return mixed
     */
    public function getJobType()
    {
        return $this->jobType;
    }

    /**
     * @return mixed
     */
    public function getSplitId()
    {
        return $this->splitId;
    }

    /**
     * @param mixed $splitId
     */
    public function setSplitId($splitId)
    {
        $this->splitId = $splitId;
    }

    public static function getObjFromArray( $result )
    {
        $job = $result['_source'];
        $j = new ESJob( $result['_id'] );
        $j->setClass( $job['class'] );
        $j->setArgs( $job['args'] );
        $j->setCreated( \DateTime::createFromFormat('Y-m-d H:i:s',$job['created']) );
        $j->setJobType( $job['jobType'] );
        $j->setRunDate( new \DateTime($job['runDate'])   );
        $j->setUserId( $job['userId']);
        $j->setSplitId($job['splitId']);
        return $j;
    }

    public static function getArrayFromObj( ESJob $job )
    {
        $j = array();
        $j['id'] = $job->getId();
        $j['class'] = $job->getClass();
        $j['args'] = $job->getArgs();
        $j['created'] = $job->getCreated()->format('Y-m-d H:i:s');
        $j['jobType'] = $job->getJobType();
        $j['runDate'] = $job->getRunDate()->format('Y-m-d');
        $j['userId']  = $job->getUserId();
        $j['splitId'] = $job->getSplitId();
        return $j;
    }


} 