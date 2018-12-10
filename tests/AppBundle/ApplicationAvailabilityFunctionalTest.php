<?php

/**
 * ApplicationAvailabity FunctionalTest
 */

namespace Tests\AppBundle;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

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
     * Test if all page is up
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
            array('/reset_password/k15b26a3d01aaoo2ed2f8effffa42d621a554be7c9821aab8238a4dc4et53e600689486629535115')
        );
    }

    /**
     * {@inheritdoc}
     */
    public function tearDown()
    {
        $this->client = null;
    }
}