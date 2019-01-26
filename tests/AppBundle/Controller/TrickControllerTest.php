<?php

/**
 * TrickController Test
 */

namespace Tests\AppBundle\Controller;

use AppBundle\Entity\User;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

/**
 * TrickControllerTest
 * @coversDefaultClass \AppBundle\Controller\TrickController
 */
class TrickControllerTest extends WebTestCase
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
     * Test addTrick method of TrickController
     * @access public
     * @covers ::addTrickAction
     *
     * @return void
     */
    public function testAddTrick()
    {
        $fileDir = __DIR__.'/../uploads/';
        copy($fileDir.'trick.jpg', $fileDir.'trick-copy.jpg');
        copy($fileDir.'snow.png', $fileDir.'snow-copy.png');

        $this->logIn();
        $crawler = $this->client->request('GET', '/tricks/add');

        $form = $crawler->selectButton('Save')->form();
        $form['appbundle_trick[name]'] = 'Trick test';
        $form['appbundle_trick[description]'] = 'A short description !';
        $selectOptions = $form['appbundle_trick[category]']->availableOptionValues();
        $form['appbundle_trick[category]']->select($selectOptions[1]);
        $values = $form->getPhpValues();
        $values['appbundle_trick']['images'][0]['file'] = new UploadedFile(
            $fileDir.'trick-copy.jpg',
            'trick-copy.jpg',
            'image/jpg',
            null,
            null,
            true
        );
        $values['appbundle_trick']['images'][1]['file'] = new UploadedFile(
            $fileDir.'snow-copy.png',
            'snow-copy.png',
            'image/png',
            null,
            null,
            true
        );

        $values['appbundle_trick']['videos'][0]['url'] = 'https://youtu.be/VZ4teZHfpkc';
        $values['appbundle_trick']['videos'][1]['url'] = 'https://www.youtube.com/watch?v=VZ4teZHfpkc';
        $values['appbundle_trick']['videos'][2]['url'] = 'https://www.youtube.com/embed/VZ4teZHfpkc';
        $values['appbundle_trick']['videos'][3]['url'] = 'https://www.dailymotion.com/video/x14wofv';
        $values['appbundle_trick']['videos'][4]['url'] = 'https://dai.ly/x14wofv';
        $values['appbundle_trick']['videos'][5]['url'] = 'https://www.dailymotion.com/embed/video/x14wofv';
        $values['appbundle_trick']['videos'][6]['url'] = 'https://vimeo.com/9636197';
        $values['appbundle_trick']['videos'][7]['url'] = 'https://player.vimeo.com/video/9636197';

        $this->client->request($form->getMethod(), $form->getUri(), $values, $form->getPhpFiles());
        $crawler = $this->client->followRedirect();

        $this->assertSame(1, $crawler->filter('div.flash-notice')->count());
    }

    /**
     * Test addTrick method of TrickController with bad values
     * @access public
     * @param string $name
     * @param string $description
     * @param UploadedFile $image
     * @param string $video
     * @param int $result
     * @covers ::addTrickAction
     * @dataProvider valuesAddTrickForm
     * 
     * @return void
     */
    public function testAddTrickWithBadValues($name, $description, $image, $video, $result)
    {
        $this->logIn();
        $crawler = $this->client->request('GET', '/tricks/add');
        $form = $crawler->selectButton('Save')->form();

        $form['appbundle_trick[name]'] = $name;
        $form['appbundle_trick[description]'] = $description;
        $values = $form->getPhpValues();

        if ($image != '') {
            $values['appbundle_trick']['images'][0]['file'] = $image;
        }

        $values['appbundle_trick']['videos'][0]['url'] = $video;

        $crawler = $this->client->request($form->getMethod(), $form->getUri(), $values, $form->getPhpFiles());

        $this->assertSame($result, $crawler->filter('span.form-error-message')->count());
    }

    /**
     * Form values
     * @access public
     *
     * @return array
     */
    public function valuesAddTrickForm()
    {
        return [
            [
                '',
                '',
                '',
                '',
                2
            ],
            [
                'n',
                '<bad description>',
                new UploadedFile(
                    __DIR__.'/../uploads/badFormat.gif',
                    'badFormat.gif',
                    'image/gif',
                    null,
                    null,
                    true
                ),
                'http://youtu.be/VZ4teZHfpkc',
                6
            ],
            [
                'a very very very very very very very very long title for a trick name',
                'baaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaad
                baaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaad
                baaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaad
                baaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaad
                baaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaad
                baaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaad
                baaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaad
                baaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaad
                baaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaad
                baaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaad
                baaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaad
                baaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaad
                baaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaad
                baaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaad
                baaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaad
                baaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaad
                baaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaad
                baaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaad
                baaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaad
                baaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaad
                baaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaad
                baaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaad
                baaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaad
                baaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaad
                baaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaad
                baaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaad
                baaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaad
                baaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaad
                baaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaad
                baaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa description',
                new UploadedFile(
                    __DIR__.'/../uploads/bigFile.jpg',
                    'bigFile.jpg',
                    'image/jpg',
                    null,
                    null,
                    true
                ),
                'https://youtu.be/VZ4teZHfpkcmcldofjnzhhzhdbsjqkqlzppzdzpdzpdpzdmpzpkgrjigirgirjgrg662233efefeffefefefeeffe
                VZ4teZHfpkcmcldofjnzhhzhdbsjqkqlzppzdzpdzpdpzdmpzpkgrjigirgirjgrg662233efefeffefefefeeffevmbkbzjefeu
                VZ4teZHfpkcmcldofjnzhhzhdbsjqkqlzppzdzpdzpdpzdmpzpkgrjigirgirjgrg662233efefeffefefefeeffevmbkbzjefeu
                VZ4teZHfpkcmcldofjnzhhzhdbsjqkqlzppzdzpdzpdpzdmpzpkgrjigirgirjgrg662233efefeffefefefeeffevmbkbzjefeu
                VZ4teZHfpkcmcldofjnzhhzhdbsjqkqlzppzdzpdzpdpzdmpzpkgrjigirgirjgrg662233efefeffefefefeeffevmbkbzjefeu
                VZ4teZHfpkcmcldofjnzhhzhdbsjqkqlzppzdzpdzpdpzdmpzpkgrjigirgirjgrg662233efefeffefefefeeffevmbkbzjefeu
                VZ4teZHfpkcmcldofjnzhhzhdbsjqkqlzppzdzpdzpdpzdmpzpkgrjigirgirjgrg662233efefeffefefefeeffevmbkbzjefeu
                VZ4teZHfpkcmcldofjnzhhzhdbsjqkqlzppzdzpdzpdpzdmpzpkgrjigirgirjgrg662233efefeffefefefeeffevmbkbzjefeu
                VZ4teZHfpkcmcldofjnzhhzhdbsjqkqlzppzdzpdzpdpzdmpzpkgrjigirgirjgrg662233efefeffefefefeeffevmbkbzjefeu
                VZ4teZHfpkcmcldofjnzhhzhdbsjqkqlzppzdzpdzpdpzdmpzpkgrjigirgirjgrg662233efefeffefefefeeffevmbkbzjefeu
                VZ4teZHfpkcmcldofjnzhhzhdbsjqkqlzppzdzpdzpdpzdmpzpkgrjigirgirjgrg662233efefeffefefefeeffevmbkbzjefeu
                VZ4teZHfpkcmcldofjnzhhzhdbsjqkqlzppzdzpdzpdpzdmpzpkgrjigirgirjgrg662233efefeffefefefeeffevmbkbzjefeu
                VZ4teZHfpkcmcldofjnzhhzhdbsjqkqlzppzdzpdzpdpzdmpzpkgrjigirgirjgrg662233efefeffefefefeeffevmbkbzjefeu
                VZ4teZHfpkcmcldofjnzhhzhdbsjqkqlzppzdzpdzpdpzdmpzpkgrjigirgirjgrg662233efefeffefefefeeffevmbkbzjefeu
                VZ4teZHfpkcmcldofjnzhhzhdbsjqkqlzppzdzpdzpdpzdmpzpkgrjigirgirjgrg662233efefeffefefefeeffevmbkbzjefeu
                VZ4teZHfpkcmcldofjnzhhzhdbsjqkqlzppzdzpdzpdpzdmpzpkgrjigirgirjgrg662233efefeffefefefeeffevmbkbzjefeu
                VZ4teZHfpkcmcldofjnzhhzhdbsjqkqlzppzdzpdzpdpzdmpzpkgrjigirgirjgrg662233efefeffefefefeeffevmbkbzjefeu
                VZ4teZHfpkcmcldofjnzhhzhdbsjqkqlzppzdzpdzpdpzdmpzpkgrjigirgirjgrg662233efefeffefefefeeffevmbkbzjefeu
                VZ4teZHfpkcmcldofjnzhhzhdbsjqkqlzppzdzpdzpdpzdmpzpkgrjigirgirjgrg662233efefeffefefefeeffevmbkbzjefeu
                VZ4teZHfpkcmcldofjnzhhzhdbsjqkqlzppzdzpdzpdpzdmpzpkgrjigirgirjgrg662233efefeffefefefeeffevmbkbzjefeu
                VZ4teZHfpkcmcldofjnzhhzhdbsjqkqlzppzdzpdzpdpzdmpzpkgrjigirgirjgrg662233efefeffefefefeeffevmbkbzjefeu',
                7
            ]
        ];
    }

    /**
     * Test path to access add trick page
     * @access public
     *
     * @return void
     */
    public function testPathToAddTrick()
    {
        $this->logIn();

        $crawler = $this->client->request('GET', '/');

        $link = $crawler->selectLink('Add trick')->link();
        $crawler = $this->client->click($link);

        $this->assertSame(' SnowTricks - Add trick', $crawler->filter('title')->text());
    }

    /**
     * Test the user can't access url if he's not logged
     * @access public
     * @param string $url
     * @dataProvider urlNoAuthUserCantAccess
     *
     * @return void
     */
    public function testNoAuthUserCantAccess($url)
    {
        $this->client->request('GET', $url);
        $crawler = $this->client->followRedirect();

        $this->assertSame('Login', $crawler->filter('h1')->text());
    }

    /**
     * Url values
     * @access public
     *
     * @return array
     */
    public function urlNoAuthUserCantAccess()
    {
        return [
            [
                '/tricks/add'
            ]
        ];
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