<?php
use Silex\WebTestCase;
class controllersTest extends WebTestCase
{
    public function testGetHomepage()
    {
        $client = $this->createClient();
        $client->followRedirects(true);
        for ($i = 0; $i < 100; $i++) {
            $crawler = $client->request('GET', '/');
            $this->assertTrue($client->getResponse()->isOk());
        }
    }
    public function createApplication()
    {
        $app = require __DIR__.'/../src/app.php';
        require __DIR__.'/../config/dev.php';
        require __DIR__.'/../src/controllers.php';
        $app['session.test'] = true;
        return $this->app = $app;
    }
}
