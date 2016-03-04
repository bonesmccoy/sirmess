<?php


namespace Bones\SirMess\Model;


interface ConversationInterface
{

    /** @return string */
    public function getId();

    /** @return Person[] */
    public function getPersonList();

    /** @return Message[] */
    public function getMessageList();
}
