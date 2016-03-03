<?php

namespace spec\Bones\SirMess\Model;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ConversationSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Bones\SirMess\Model\Conversation');
    }
}
