<?php

/**
 * ApiController Test
 */

namespace Tests\AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Entity\Trick;
use AppBundle\Entity\Video;
use AppBundle\Entity\Comment;
use AppBundle\Entity\TrickImage;
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
     * Test getComments method of ApiController (Ajax)
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

        $this->assertEquals(10, count($datas));

        $this->assertSame('BryanEnabled TestEnabled', $firstComment['author']);
        $this->assertSame('Twelfth', $firstComment['content']);  
        $this->assertTrue(file_exists($firstAbsoluteImgSrc));
        $this->assertEquals(1, preg_match($dateRegex, $firstComment['date']));

        $this->assertSame('BryanEnabled TestEnabled', $lastComment['author']);
        $this->assertSame('Third', $lastComment['content']);  
        $this->assertTrue(file_exists($lastAbsoluteImgSrc));
        $this->assertEquals(1, preg_match($dateRegex, $lastComment['date']));
    }

    /**
     * Test getComments with null request header (Ajax)
     * @access public
     * @covers ::getComments
     *
     * @return void
     */
    public function testGetCommentsWithNullRequestHeader()
    {
        $trick = $this->client
            ->getContainer()
            ->get('doctrine')
            ->getManager()
            ->getRepository(Trick::class)
            ->getTrick('a-simple-trick')
        ;

        $this->client->request('GET', '/api/comments/' .$trick->getId(). '/0');

        $this->assertTrue($this->client->getResponse()->isNotFound());
    }

    /**
     * Test getComments with a bad request method (Ajax)
     *
     * @return void
     */
    public function testGetCommentsWithBadRequestMethod()
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
            'DELETE',
            $url,
            array(),
            array(),
            array('HTTP_X-Requested-With' => 'XMLHttpRequest')
        );

        $this->assertEquals(405, $this->client->getResponse()->getStatusCode());
    }

    /**
     * Test ajax request with bad parameter
     * @access public
     * @param string $method
     * @param string $url
     * @dataProvider valuesAjaxRequest
     * 
     * @return void
     */
    public function testAjaxRequestWithABadParam($method, $url)
    {
        $this->client->request(
            $method,
            $url,
            array(),
            array(),
            array('HTTP_X-Requested-With' => 'XMLHttpRequest')
        );

        $this->assertEmpty(json_decode($this->client->getResponse()->getContent()));
    }

    /**
     * Values for testAjaxRequestWithABadParam
     * @access public
     *
     * @return array
     */
    public function valuesAjaxRequest()
    {
        return [
            [
                'GET',
                '/api/comments/0/0'
            ],
            [
                'GET',
                '/api/tricks/100'
            ]
        ];
    }

    /**
     * Test deleteTrickAction (Ajax)
     * @access public
     * @covers ::deleteTrickAction
     *
     * @return void
     */
    public function testDeleteTrickWithAjax()
    {
        $this->logIn();

        $manager = $this->client->getContainer()->get('doctrine')->getManager();
        $trick = $manager->getRepository(Trick::class)->getTrick('a-very-bad-bad-bad-trick');
        $trickId = $trick->getId();
        $firstVideoId = $trick->getVideos()[0]->getId();
        $firstImg = $trick->getImages()[0];
        $firstImgId = $firstImg->getId();
        $firstImgThumbPath = __DIR__.'/../../../web/' .$firstImg->getUploadWebTestThumbPath(); 
        $firstImgLargePath = __DIR__.'/../../../web/' .$firstImg->getUploadWebTestLargePath();
        
        $this->client->request(
            'DELETE',
            '/api/trick/a-very-bad-bad-bad-trick/delete',
            array(),
            array(),
            array('HTTP_X-Requested-With' => 'XMLHttpRequest')
        );

        $response = json_decode($this->client->getResponse()->getContent(), true);

        $this->assertTrue($response['result']);
        $this->assertSame($response['message'], 'Success ! Trick was deleted !');

        $deletedTrick = $manager->getRepository(Trick::class)->find($trickId);
        $deletedImg = $manager->getRepository(TrickImage::class)->find($firstImgId);
        $deletedVideo = $manager->getRepository(Video::class)->find($firstVideoId);
        $firstComment = $manager->getRepository(Comment::class)->findOneByContent(array('Delete me'));
        $thumbImgExist = file_exists($firstImgThumbPath);
        $largeImgExist = file_exists($firstImgLargePath);

        $this->assertNull($deletedTrick);
        $this->assertNull($deletedImg);
        $this->assertNull($deletedVideo);
        $this->assertNull($firstComment);
        $this->assertFalse($thumbImgExist);
        $this->assertFalse($largeImgExist);
    }

    /**
     * Test to delete a trick with Ajax if user is not authenticated
     * @access public
     * 
     * @return void
     */
    public function testDeleteTrickWithAjaxIfUserIsNotAuth()
    {
        $this->client->request(
            'DELETE',
            '/api/trick/a-very-bad-bad-bad-trick/delete',
            array(),
            array(),
            array('HTTP_X-Requested-With' => 'XMLHttpRequest')
        );

        $response = json_decode($this->client->getResponse()->getContent(), true);

        $this->assertFalse($response['result']);
        $this->assertSame($response['message'], 'You are not authenticated !');
    }

    /**
     * Test to delete a trick with an Ajax request and a unknow trick slug
     * @access public
     *
     * @return void
     */
    public function testDeleteTrickWithAjaxAndUnknowSlug()
    {
        $this->logIn();

        $this->client->request(
            'DELETE',
            '/api/trick/unknow-slug/delete',
            array(),
            array(),
            array('HTTP_X-Requested-With' => 'XMLHttpRequest')
        );

        $this->assertTrue($this->client->getResponse()->isNotFound());
    }

    /**
     * Test Ajax request with a bad request method
     * @access public
     * @param string $method
     * @param string $url
     * @dataProvider valuesAjaxBadRequest
     *
     * @return void
     */
    public function testAjaxRequestWithBadRequestMethod($method, $url)
    {
        $this->logIn();

        $this->client->request(
            $method,
            $url,
            array(),
            array(),
            array('HTTP_X-Requested-With' => 'XMLHttpRequest')
        );

        $this->assertEquals(405, $this->client->getResponse()->getStatusCode());
    }

    /**
     * Values for testAjaxRequestWithBadRequestMethod
     *
     * @return array
     */
    public function valuesAjaxBadRequest()
    {
        return [
            [
                'GET',
                '/api/trick/bad-method/delete'
            ],
            [
                'DELETE',
                '/api/tricks/15',
            ]
        ];
    }

    /**
     * Test Ajax request with a null HTTP header
     * @access public
     * @param string $method
     * @param string $url
     * @dataProvider valuesAjaxNullHttpHeader
     * 
     * @return void
     */
    public function testAjaxRequestWithNullHtttpHeader($method, $url)
    {
        $this->logIn();

        $this->client->request(
            $method,
            $url,
            array(),
            array(),
            array()
        );

        $this->assertTrue($this->client->getResponse()->isNotFound());
    }

    /**
     * Values for testAjaxRequestWithNullHttpHeader
     * @access public
     *
     * @return array
     */
    public function valuesAjaxNullHttpHeader()
    {
        return [
            [
                'DELETE',
                '/api/trick/a-simple-trick/delete'
            ],
            [
                'GET',
                '/api/tricks/15',
            ]
        ];
    }

    /**
     * Test path Home - Delete trick (Ajax)
     * @access public
     *
     * @return void
     */
    public function testPathHomeToDeleteTrick()
    {
        $this->logIn();

        $crawler = $this->client->request('GET', '/');
 
        $this->assertEquals(1, $crawler->filter('a[href="/api/trick/twelfth-trick/delete"]')->count());
    }

    /**
     * Test getTricksAction, get tricks with ajax
     * @access public
     *
     * @return void
     */
    public function testGetTricks()
    {
        $this->client->request(
            'GET',
            '/api/tricks/15',
            array(),
            array(),
            array('HTTP_X-Requested-With' => 'XMLHttpRequest')
        );

        $datas = json_decode($this->client->getResponse()->getContent(), true);

        $firstTrick = $datas[0];
        $secondTrick = $datas[1];

        $firstAbsoluteImgSrc = __DIR__.'/../../../web/'.$firstTrick['imgSrc'];
        $secondAbsoluteImgSrc = __DIR__.'/../../../web/'.$secondTrick['imgSrc'];

        $this->assertEquals(2, count($datas));

        $this->assertSame('A simple trick', $firstTrick['name']);
        $this->assertSame('A very good Trick', $secondTrick['name']); 

        $this->assertSame('a-simple-trick', $firstTrick['slug']);
        $this->assertSame('a-very-good-trick', $secondTrick['slug']);

        $this->assertTrue(file_exists($firstAbsoluteImgSrc));
        $this->assertTrue(file_exists($secondAbsoluteImgSrc));
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