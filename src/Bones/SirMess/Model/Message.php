<?php


namespace Bones\SirMess\Model;


class Message
{

    protected $_id;

    protected $title;

    protected $body;

    /** @var User  */
    protected $sender;

    /**
     * @var DateTime
     */
    private $date;

    /**
     * @var User[]
     */
    protected $recipients = array();

    /**
     * @var User[]
     */
    protected $readers = array();


    public function __construct(User $sender, $title, $body, \DateTime $date)
    {
        $this->sender = $sender;
        $this->title = $title;
        $this->body = $body;
        $this->date = $date;
    }


    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->_id;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return mixed
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }



    /**
     * @return mixed
     */
    public function getSender()
    {
        return $this->sender;
    }

    /**
     * @return User[]
     */
    public function getRecipients()
    {
        return $this->recipients;
    }


    public function addRecipient(User $user)
    {
        $this->recipients[$user->getId()] = $user;
    }


    /**
     * @return User[]
     */
    public function getReaders()
    {
        return $this->readers;
    }


    public function markAsReadFromUser(User $user)
    {
        if (isset($this->recipients[$user->getId()]) &&
            !isset($this->readers[$user->getId()])
        ) {
            $this->readers[$user->getId()] = new \DateTime();
        }
    }

    public function isReadFromUser(User $user)
    {
        return (isset($this->readers[$user->getId()]));
    }

    public function getReadDateForUser(User $user)
    {
        return  $this->isReadFromUser($user)? $this->readers[$user->getId()] : null;
    }

    public function markAsUnreadForUser(User $user)
    {
        if (isset($this->readers[$user->getId()])) {
            unset($this->readers[$user->getId()]);
        }
    }


}
