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

        $this->assertEquals(
            'application/json',
            $response->headers->get('content-type')
        );


        $this->assertTrue($client->getResponse()->isOk());

    }


}
