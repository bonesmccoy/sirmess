<?php


namespace tests\Bones\SirMess\Controller;


use Bones\Component\Fixture\FixtureLoader;

class MailboxControllerTest extends BaseWebTestCase
{

    /**
     * @var FixtureLoader
     */
    protected $fixtureLoader;


    public function setUp()
    {
        parent::setUp();
        $this->fixtureLoader =  FixtureLoader::factoryMongoFixtureLoader($this->app['config_path'] . "/bongo.yml");
        $this->fixtureLoader->addFixturesFromConfiguration($this->app['config_path'] . "/bongo.yml");
        $this->fixtureLoader->persistLoadedFixtures();
    }


    public function testOutboxForPerson1()
    {
        $client = $this->createClient();
        $client->request('GET', '/mailbox/outbox/1');
        $response = $client->getResponse();
        $this->assertTrue($client->getResponse()->isOk());

        $this->assertEquals(
            'application/json',
            $response->headers->get('content-type')
        );

        $conversationList = json_decode($response->getContent(), true);

        $this->assertCount(
            1,
            $conversationList
        );

        $conversation = current($conversationList);

        $this->assertArrayHasKey(
            'messageList',
            $conversation
        );

        $this->expectSenderInConversation($conversation, 1);

        $this->assertArrayHasKey(
            'personList',
            $conversation
        );

        $expectedPersonInConversation = 1;

        $this->expectPersonInConversation($conversation, $expectedPersonInConversation);

    }


    public function testOutboxLimited10()
    {
        $client = $this->createClient();
        $client->request('GET', '/mailbox/outbox/10?offset=0&limit=2');
        $response = $client->getResponse();
        $this->assertTrue($client->getResponse()->isOk());

        $this->assertEquals(
            'application/json',
            $response->headers->get('content-type')
        );

        $conversationList = json_decode($response->getContent(), true);

        $this->assertCount(
            2,
            $conversationList
        );

        $conversation = current($conversationList);

        $this->assertArrayHasKey(
            'messageList',
            $conversation
        );

        $expectedSender = 10;
        $this->expectSenderInConversation($conversation, $expectedSender);

        foreach($conversationList as $conversation)
        {
            $this->assertTrue(
                in_array($conversation["id"], array("10", "11")),
                $conversation["id"] . " not found in [10, 11]"
            );
        }
    }


    public function testInboxForPerson2()
    {
        $client = $this->createClient();
        $client->request('GET', '/mailbox/inbox/2');
        $response = $client->getResponse();
        $this->assertTrue($client->getResponse()->isOk());

        $this->assertEquals(
            'application/json',
            $response->headers->get('content-type')
        );

        $conversationList = json_decode($response->getContent(), true);

        $this->assertCount(
            1,
            $conversationList
        );

        $conversation = current($conversationList);

        $this->assertArrayHasKey(
            'messageList',
            $conversation
        );

        $foundMessageAsRecipient = false;
        foreach($conversation['messageList'] as $message) {
            foreach($message['recipients'] as $recipient) {
                if (isset($recipient['id']) && $recipient['id'] == 2) {
                    $foundMessageAsRecipient = true;
                    break;
                }
            }
        }

        $this->assertTrue($foundMessageAsRecipient, "No message found in the conversation with person 2 as recipient");

        $this->assertArrayHasKey(
            'personList',
            $conversation
        );

        $this->expectPersonInConversation($conversation, 2);
    }

    public function testInboxLimited11()
    {
        $client = $this->createClient();
        $client->request('GET', '/mailbox/inbox/11?offset=0&limit=2');
        $response = $client->getResponse();
        $this->assertTrue($client->getResponse()->isOk());

        $this->assertEquals(
            'application/json',
            $response->headers->get('content-type')
        );

        $conversationList = json_decode($response->getContent(), true);

        $this->assertCount(
            2,
            $conversationList
        );

        $conversation = current($conversationList);

        $this->assertArrayHasKey(
            'messageList',
            $conversation
        );

        $expectedSender = 10;
        $this->expectSenderInConversation($conversation, $expectedSender);

        foreach($conversationList as $conversation)
        {
            $this->assertTrue(
                in_array($conversation["id"], array("10", "11")),
                $conversation["id"] . " not found in [10, 11]"
            );
        }
    }



    /**
     * @param $conversation
     * @param $expectedSender
     */
    private function expectSenderInConversation($conversation, $expectedSender)
    {
        $foundMessageAsSender = false;
        foreach ($conversation['messageList'] as $message) {
            if (isset($message['sender']['id']) && $message['sender']['id'] == $expectedSender) {
                $foundMessageAsSender = true;
                break;
            }
        }

        $this->assertTrue($foundMessageAsSender, "No message found in the conversation with person $expectedSender as sender");
    }

    /**
     * @param $conversation
     * @param $expectedPersonInConversation
     */
    private function expectPersonInConversation($conversation, $expectedPersonInConversation)
    {
        $foundPersonInConversation = false;
        foreach ($conversation['personList'] as $person) {
            if ($person['id'] == $expectedPersonInConversation) {
                $foundPersonInConversation = true;
                break;
            }
        }

        $this->assertTrue($foundPersonInConversation, "No person $expectedPersonInConversation found in conversation person list");
    }
}
