<?php

namespace spec\Bones\SirMess\Model;

use Bones\SirMess\Model\User;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class MessageSpec extends ObjectBehavior
{
    function let(User $user)
    {
        $user->beADoubleOf('Bones\SirMess\Model\User');
        $this->beConstructedWith($user, 'title', 'body');

    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Bones\SirMess\Model\Message');
    }

    function it_should_add_recipient()
    {
        $user = new User(3);
        $this->addRecipient($user);
        $this->getRecipients()->shouldHaveCount(1);
    }

    function it_should_add_another_recipient()
    {
        $user = new User(4);
        $this->addRecipient($user);

        $user = new User(5);
        $this->addRecipient($user);

        $this->getRecipients()->shouldHaveCount(2);
    }

    function it_shouldnt_add_a_recipient_twice()
    {
        $user = new User(3);
        $this->addRecipient($user);
        $this->addRecipient($user);
        $this->getRecipients()->shouldHaveCount(1);
    }

    function it_can_be_marked_as_read()
    {
        $user = new User(3);
        $this->addRecipient($user);
        $this->markAsReadFromUser($user);
    }

    function it_can_be_marked_as_read_only_from_existing_recipients()
    {
        $user = new User(3);
        $this->addRecipient($user);
        $this->markAsReadFromUser($user);
        $this->getReaders()->shouldHaveCount(1);

        $user = new User(4);
        $this->markAsReadFromUser($user);
        $this->getReaders()->shouldHaveCount(1);
    }

    function it_can_have_read_date_for_a_given_user()
    {
        $user = new User(3);
        $this->addRecipient($user);
        $this->markAsReadFromUser($user);
        $this->getReaders()->shouldHaveCount(1);

        $this->getReadDateForUser($user);
    }

    function it_can_be_set_unread_for_a_give_user()
    {
        $user = new User(3);
        $this->addRecipient($user);
        $this->markAsReadFromUser($user);
        $this->getReaders()->shouldHaveCount(1);

        $this->markAsUnreadForUser($user);
        $this->getReaders()->shouldHaveCount(0);
    }



}
