<?php

namespace Tests\AppBundle\Controller;

use AppBundle\Entity\User;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

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

    public function testPathToAddTrick()
    {
        $this->logIn();

        $crawler = $this->client->request('GET', '/');

        $link = $crawler->selectLink('Add trick')->link();
        $crawler = $this->client->click($link);

        $this->assertSame(' SnowTricks - Add trick', $crawler->filter('title')->text());
    }

    /**
     * @dataProvider urlNoAuthUserCantAccess
     */
    public function testNoAuthUserCantAccess($url)
    {
        $this->client->request('GET', $url);
        $crawler = $this->client->followRedirect();

        $this->assertSame('Login', $crawler->filter('h1')->text());
    }

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