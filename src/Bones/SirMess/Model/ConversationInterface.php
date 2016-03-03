<?php


namespace Bones\SirMess\Model;


interface ConversationInterface
{

    /** @return string */
    public function getId();

    /** @return User[] */
    public function getUserList();

    /** @return Message[] */
    public function getMessageList();
}
