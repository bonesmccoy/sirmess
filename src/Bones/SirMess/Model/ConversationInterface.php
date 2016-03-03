<?php


namespace Bones\SirMess\Model;


interface ConversationInterface
{

    /** @return string */
    public function getId();

    /** @return User[] */
    public function getUsers();

    /** @return Message[] */
    public function getMessageList();
}
