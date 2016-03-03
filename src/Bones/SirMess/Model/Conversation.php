<?php

namespace Bones\SirMess\Model;

class Conversation implements ConversationInterface
{
    /**
     * @var Message[]
     */
    protected $messageList = array();

    /**
     * @var User[]
     */
    protected $userList = array();

    /** @return string */
    public function getId()
    {
        // TODO: Implement getId() method.
    }

    /** @return User[] */
    public function getUserList()
    {
        return $this->userList;
    }

    /** @return Message[] */
    public function getMessageList()
    {
        return $this->messageList;
    }

    /**
     * @param Message $message
     */
    public function addMessage(Message $message)
    {
        $this->messageList[$message->getDate()->format("Ymdhist")] = $message;
        $this->addUsersFromMessage($message);

     }

    private function addUsersFromMessage(Message $message)
    {
        $sender = $message->getSender();
        $this->addUserIfNotExists($sender);
        foreach($message->getRecipients() as $recipient) {
            $this->addUserIfNotExists($recipient);
        }
    }

    /**
     * @param User $user
     */
    private function addUserIfNotExists(User $user)
    {
        if (!isset($this->userList[$user->getId()])) {
            $this->userList[$user->getId()] = $user;
        }
    }
}
