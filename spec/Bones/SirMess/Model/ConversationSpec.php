<?php

namespace spec\Bones\SirMess\Model;

use Bones\SirMess\Model\Conversation;
use Bones\SirMess\Model\Message;
use Bones\SirMess\Model\Person;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ConversationSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Bones\SirMess\Model\Conversation');
    }

    function it_can_add_a_message()
    {
        $sender = new Person(1);
        $conversation = new Conversation();
        $message = new Message($conversation, $sender, 'body');

        $this->addMessage($message);
        $this->getMessageList()->shouldHaveCount(1);
    }

    function it_should_add_users_from_the_inserted_message()
    {
        $sender = new Person(1);
        $conversation = new Conversation();
        $message = new Message($conversation, $sender, 'body');

        $firstRecipient = new Person(2);
        $message->addRecipient($firstRecipient);

        $this->addMessage($message);
        $this->getPersonList()->shouldHaveCount(2);
    }
}
