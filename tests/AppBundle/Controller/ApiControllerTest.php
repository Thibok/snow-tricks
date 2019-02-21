<?php

/**
 * ApiController Test
 */

namespace Tests\AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Entity\Trick;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

/**
 * ApiControllerTest
 * @coversDefaultClass \AppBundle\Controller\ApiController
 */
class ApiControllerTest extends WebTestCase
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
     * Test getComments method of ApiController
     * @access public
     * @covers ::getComments
     *
     * @return void
     */
    public function testGetComments()
    {
        $trick = $this->client
            ->getContainer()
            ->get('doctrine')
            ->getManager()
            ->getRepository(Trick::class)
            ->getTrick('a-simple-trick')
        ;

        $url = '/api/comments/' .$trick->getId(). '/0';
        $this->client->request(
            'GET',
            $url,
            array(),
            array(),
            array('HTTP_X-Requested-With' => 'XMLHttpRequest')
        );

        $dateRegex = '#^([0-9]{2}-){2}[0-9]{4} at [0-9]{2}h[0-9]{2}min [0-9]{2}s$#';

        $datas = json_decode($this->client->getResponse()->getContent(), true);
        $firstComment = $datas[0];
        $lastComment = $datas[9];

        $firstAbsoluteImgSrc = __DIR__.'/../../../web/'.$firstComment['imgSrc'];
        $lastAbsoluteImgSrc = __DIR__.'/../../../web/'.$lastComment['imgSrc'];

        $this->assertSame(10, count($datas));

        $this->assertSame('BryanEnabled TestEnabled', $firstComment['author']);
        $this->assertSame('Twelfth', $firstComment['content']);  
        $this->assertTrue(file_exists($firstAbsoluteImgSrc));
        $this->assertSame(1, preg_match($dateRegex, $firstComment['date']));

        $this->assertSame('BryanEnabled TestEnabled', $lastComment['author']);
        $this->assertSame('Third', $lastComment['content']);  
        $this->assertTrue(file_exists($lastAbsoluteImgSrc));
        $this->assertSame(1, preg_match($dateRegex, $lastComment['date']));
    }

    /**
     * Test getComments with bad request
     * @access public
     * @covers ::getComments
     *
     * @return void
     */
    public function testGetCommentsWithBadrequest()
    {
        $trick = $this->client
            ->getContainer()
            ->get('doctrine')
            ->getManager()
            ->getRepository(Trick::class)
            ->getTrick('a-simple-trick')
        ;

        $this->client->request('GET', '/api/comments/' .$trick->getId(). '/0');

        $this->assertSame(404, $this->client->getResponse()->getStatusCode());
    }

    /**
     * {@inheritdoc}
     */
    public function tearDown()
    {
        $this->client = null;
    }
}