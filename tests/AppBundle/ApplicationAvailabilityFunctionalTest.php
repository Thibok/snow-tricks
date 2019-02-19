<?php

/**
 * ApplicationAvailabity FunctionalTest
 */

namespace Tests\AppBundle;

use Symfony\Component\BrowserKit\Cookie;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

/**
 * ApplicationAvailabilityFunctionalTest
 */
class ApplicationAvailabilityFunctionalTest extends WebTestCase
{
    /**
     * @var Client
     * @access private
     */
    private $client;
    
    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        $this->client = self::createClient();
    }

    /**
     * Test if all page with no authentication is up
     * @access public
     * @param array $url
     * @dataProvider urlProvider
     * 
     * @return void
     */
    public function testPageIsSuccessful($url)
    {
        $this->client->request('GET', $url);

        $this->assertTrue($this->client->getResponse()->isSuccessful());
    }

    /**
     * Test if all page with authentication is up
     * @access public
     * @param array $url
     * @dataProvider authUrlProvider
     * 
     * @return void
     */
    public function testPageNeedToBeLoggedIsSuccessful($url)
    {
        $this->logIn();

        $this->client->request('GET', $url);

        $this->assertTrue($this->client->getResponse()->isSuccessful());
    }

    /**
     * Url values
     * @access public
     *
     * @return array
     */
    public function urlProvider()
    {
        return array(
            array('/registration'),
            array('/login'),
            array('/forgot_password'),
            array('/reset_password/k15b26a3d01aaoo2ed2f8effffa42d621a554be7c9821aab8238a4dc4et53e600689486629535115'),
            array('/tricks/details/a-simple-trick'),
        );
    }

    /**
     * Url values
     * @access public
     *
     * @return array
     */
    public function authUrlProvider()
    {
        return array(
            array('/tricks/add'),
            array('/tricks/details/a-simple-trick/update'),
        );
    }

    /**
     * Log user
     * @access private
     *
     * @return void
     */
    private function logIn()
    {
        $session = $this->client->getContainer()->get('session');

        $firewallName = 'main';
        $firewallContext = 'main';
        $em = $this->client->getContainer()->get('doctrine')->getManager(); 
        $user = $em->getRepository('AppBundle:User')->findOneByUsername('EnabledUser'); 

        $token = new UsernamePasswordToken($user, $user->getPassword(), $firewallName, $user->getRoles());
        $session->set('_security_'.$firewallContext, serialize($token));
        $session->save();

        $cookie = new Cookie($session->getName(), $session->getId());
        $this->client->getCookieJar()->set($cookie);
    }

    /**
     * {@inheritdoc}
     */
    public function tearDown()
    {
        $this->client = null;
    }
}