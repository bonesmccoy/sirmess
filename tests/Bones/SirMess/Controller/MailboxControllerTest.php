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

        $foundMessageAsSender = false;
        foreach($conversation['messageList'] as $message) {
            if (isset($message['sender']['id']) && $message['sender']['id'] == 1) {
                $foundMessageAsSender = true;
                break;
            }
        }

        $this->assertTrue($foundMessageAsSender, "No message found in the conversation with person 1 as sender");

        $this->assertArrayHasKey(
            'personList',
            $conversation
        );

        $foundPersonInConversation = false;
        foreach($conversation['personList'] as $person) {
            if ($person['id'] == 1) {
                $foundPersonInConversation = true;
                break;
            }
        }

        $this->assertTrue($foundPersonInConversation, "No person 1 found in conversation person list");

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

        $foundPersonInConversation = false;
        foreach($conversation['personList'] as $person) {
            if ($person['id'] == 2) {
                $foundPersonInConversation = true;
                break;
            }
        }

        $this->assertTrue($foundPersonInConversation, "No person 2 found in conversation person list");
    }
}
