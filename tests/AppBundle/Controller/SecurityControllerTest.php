<?php

/**
 * SecurityController Test
 */

namespace Tests\AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Entity\Token;
use AppBundle\Entity\UserImage;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

/**
 * SecurityControllerTest
 * @coversDefaultClass \AppBundle\Controller\SecurityController
 */
class SecurityControllerTest extends WebTestCase
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
     * Test Registration method of SecurityController
     * @access public
     * @covers ::registrationAction
     *
     * @return void
     */
    public function testRegistration()
    {
        $crawler = $this->client->request('GET', '/registration');

        $form = $crawler->selectButton('Create an account')->form();
        $form['appbundle_user[username]'] = 'Zebulon';
        $form['appbundle_user[email]'] = 'zebulontest@yahoo.fr';
        $form['appbundle_user[password]'] = 'averygreatepassword45';
        $form['appbundle_user[name]'] = 'Example';
        $form['appbundle_user[firstName]'] = 'Jean';
        $form['appbundle_user[image][file]']->upload(
            new UploadedFile(
                __DIR__.'/../uploads/userimage.png',
                'userimage.png',
                'image/png',
                null,
                null,
                true
            )
        );

        $this->client->submit($form);
        $crawler = $this->client->followRedirect();
        
        $this->assertEquals(2, $crawler->filter('div.flash-notice')->count());

        $manager = $this->client->getContainer()->get('doctrine')->getManager();
        $encoder = $this->client->getContainer()->get('security.password_encoder');

        $user = $manager->getRepository(User::class)->findOneByUsername('Zebulon');

        $this->assertSame('Zebulon', $user->getUsername());
        $this->assertSame('zebulontest@yahoo.fr', $user->getEmail());
        $this->assertSame('Example', $user->getName());
        $this->assertSame('Jean', $user->getFirstName());
        $this->assertEquals(0, $user->getIsActive());
        $this->assertTrue($encoder->isPasswordValid($user, 'averygreatepassword45'));
    }

    /**
     * Test the path to registration (Home - Registration)
     * @access public
     *
     * @return void
     */
    public function testPathToRegistration()
    {
        $crawler = $this->client->request('GET', '/');

        $link = $crawler->selectLink('Sign in')->link();
        $crawler = $this->client->click($link);

        $this->assertSame('Registration', $crawler->filter('h1')->text());
    }

    /**
     * Test Registration method of SecurityController with bad values
     * @access public
     * @param string $username
     * @param string $email
     * @param string $pass
     * @param string $name
     * @param string $firstName
     * @param UploadedFile $image
     * @param int $result
     * @covers ::registrationAction
     * @dataProvider valuesRegistrationForm
     *
     * @return void
     */
    public function testRegistrationWithBadValues($username, $email, $pass, $name, $firstName, $image, $result)
    {
        $crawler = $this->client->request('GET', '/registration');

        $form = $crawler->selectButton('Create an account')->form();
        $form['appbundle_user[username]'] = $username;
        $form['appbundle_user[email]'] = $email;
        $form['appbundle_user[password]'] = $pass;
        $form['appbundle_user[name]'] = $name;
        $form['appbundle_user[firstName]'] = $firstName;
        $form['appbundle_user[image][file]']->upload($image);

        $crawler = $this->client->submit($form);

        $this->assertEquals($result, $crawler->filter('span.form-error-message')->count());     
    }

    /**
     * Form values
     * @access public
     *
     * @return array
     */
    public function valuesRegistrationForm()
    {
        return [
            [
                '',
                '',
                '',
                '',
                '',
                '',
                6
            ],
            [
                '!',
                '!',
                'sd',
                '!',
                '!',
                new UploadedFile(
                    __DIR__.'/../uploads/badFormat.gif',
                    'badFormat.gif',
                    'image/gif',
                    null,
                    null,
                    true
                ),
                11
            ],
            [
                'azertyuiopqsdfghjklmwxcvbnhjghr',
                'azertyuiopqsdfghjklmwxcvbnhjgrazertyuiopqsdfghjklmwxcvbnhjgr@yahooo.com',
                'azertyuiopqsdfghjklmwxcvbnhjgr56951fslepfmvjbfz2c',
                'azertyuiopqsdfghjklmwxcvbnhjgr-hhhmmhlkvg',
                'azertyuiopqsdfghjklmwxcvbnhjgr-hhhmmhlkvg',
                new UploadedFile(
                    __DIR__.'/../uploads/bigFile.jpg',
                    'bigFile.jpg',
                    'image/jpeg',
                    null,
                    null,
                    true
                ),
                6
            ]
        ];
    }

    /**
     * Test Valid Registration method of SecurityController
     * @access public
     * @covers ::validRegistrationAction
     *
     * @return void
     */
    public function testValidRegistration()
    {
        $this->client->request(
            'GET',
            '/registration/validation/c15b26a3d01aa113ed235d570ca43d621a552be7c9821aab8238a40f40b53e686689559629535112'
        );

        $crawler = $this->client->followRedirect();

        $this->assertEquals(1, $crawler->filter('div.flash-notice')->count());

        $manager = $this->client->getContainer()->get('doctrine')->getManager();
        $token = $manager
            ->getRepository(Token::class)
            ->getTokenWithUser('c15b26a3d01aa113ed235d570ca43d621a552be7c9821aab8238a40f40b53e686689559629535112')
        ;

        $user = $manager->getRepository(User::class)->findOneByUsername('GoodUser');

        $this->assertNull($token);
        $this->assertEquals(1, $user->getIsActive());
    }

    /**
     * Test valid registration with expired token
     * @access public
     *
     * @return void
     */
    public function testValidRegistrationWithExpiredToken()
    {
        $this->client->request(
            'GET',
            '/registration/validation/w1fb48a3d01aa113ed2fcd5e52a43d621a552be7c9821aab8238a40f40b53868668v5596h95351lo'
        );

        $this->assertTrue($this->client->getResponse()->isNotFound());
    }

    /**
     * Test validRegistration method of SecurityController with bad token
     * @access public
     * @covers ::validRegistrationAction
     *
     * @return void
     */
    public function testValidRegistrationWithBadToken()
    {
        $this->client->request('GET', '/registration/validation/rdfpdfpfd58978512');

        $this->assertTrue($this->client->getResponse()->isNotFound());
    }

    /**
     * Test the path to login (Home - Login)
     * @access public
     *
     * @return void
     */
    public function testPathToLogin()
    {
        $crawler = $this->client->request('GET', '/');

        $link = $crawler->selectLink('Sign up')->link();
        $crawler = $this->client->click($link);

        $this->assertSame('Login', $crawler->filter('h1')->text());
    }

    /**
     * Test Login method of SecurityController
     * @access public
     * @covers ::loginAction
     *
     * @return void
     */
    public function testLogin()
    {
        $crawler = $this->client->request('GET', '/login');

        $form = $crawler->selectButton('Login')->form();
        $form['_username'] = 'EnabledUser';
        $form['_password'] = 'verystrongpassword123';

        $this->client->submit($form);
        $crawler = $this->client->followRedirect();
        
        $this->assertEquals(1, $crawler->filter('div.flash-notice')->count());
    }

    /**
     * Test Registration method of SecurityController with bad values
     * @access public
     * @param string $username
     * @param string $pass
     * @covers ::loginAction
     * @dataProvider valuesLoginForm
     *
     * @return void
     */
    public function testLoginWithBadValues($username, $pass)
    {
        $crawler = $this->client->request('GET', '/login');

        $form = $crawler->selectButton('Login')->form();
        $form['_username'] = $username;
        $form['_password'] = $pass;

        $this->client->submit($form);
        $crawler = $this->client->followRedirect();
        
        $this->assertEquals(1, $crawler->filter('div[class="alert alert-danger"]')->count());    
    }

    /**
     * Form values
     * @access public
     *
     * @return array
     */
    public function valuesLoginForm()
    {
        return [
            [
                '',
                ''
            ],
            [
                'InactiveUser',
                'verystrongpassword1222'
            ],
            [
                'EnabledUser',
                'badPass'
            ]
        ];
    }

    /**
     * Test Logout method of SecurityController
     * @access public
     * @covers ::logoutAction
     *
     * @return void
     */
    public function testLogout()
    {
        $this->logIn();
        $this->client->request('GET', '/logout');
        $crawler = $this->client->followRedirect();

        $this->assertEquals(0, $crawler->filter('a:contains("Logout")')->count());
    }

    /**
     * Test path Home - Logout
     * @access public
     *
     * @return void
     */
    public function testPathToLogout()
    {
        $this->logIn();
        $crawler = $this->client->request('GET', '/');
        $link = $crawler->filter('#logout')->link();

        $this->client->click($link);
        $crawler = $this->client->followRedirect();

        $this->assertEquals(0, $crawler->filter('a:contains("Logout")')->count());
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

        $token = new UsernamePasswordToken('simpleTest', null, $firewallName, array('ROLE_MEMBER'));
        $session->set('_security_'.$firewallContext, serialize($token));
        $session->save();

        $cookie = new Cookie($session->getName(), $session->getId());
        $this->client->getCookieJar()->set($cookie);
    }

    /**
     * Test the user access of url when he's logged
     * @access public
     * @param string $url
     * @dataProvider urlAuthUserCantAccess
     *
     * @return void
     */
    public function testAuthUserCantAccess($url)
    {
        $this->login();

        $this->client->request('GET', $url);
        $crawler = $this->client->followRedirect();

        $this->assertSame(' SnowTricks - Home', $crawler->filter('title')->text());
    }

    /**
     * User can't access that url when he's logged
     * @access public
     *
     * @return array
     */
    public function urlAuthUserCantAccess()
    {
        return [
            [
                '/registration'
            ],
            [
                '/login'
            ],
            [
                '/registration/validation/c15b26a3d01aa113ed2fcd5e52a43d621a552be7c9821aab8238a40f40b53e686689559629512869'
            ],
            [
                '/forgot_password'
            ],
            [
                '/reset_password/k15b26a3d01aaoo2ed2f8efe52a43d621a552be7c9821aab8238a4dc40b53e600689559629535115'
            ]
        ];
    }

    /**
     * Test forgot password
     * @access public
     * @covers ::forgotPassAction
     *
     * @return void
     */
    public function testForgotPass()
    {
        $crawler = $this->client->request('GET', '/forgot_password');

        $form = $crawler->selectButton('Ask for reset password')->form();
        $form['appbundle_user[username]'] = 'EnabledUser';

        $this->client->submit($form);
        $crawler = $this->client->followRedirect();

        $this->assertEquals(1, $crawler->filter('div.flash-notice')->count());
    }

    /**
     * Test forgot password with bad values
     *
     * @param string $username
     * @covers ::forgotPassAction
     * @dataProvider valuesForgotPassForm
     * 
     * @return void
     */
    public function testForgotPassWithBadValues($username)
    {
        $crawler = $this->client->request('GET', '/forgot_password');

        $form = $crawler->selectButton('Ask for reset password')->form();
        $form['appbundle_user[username]'] = $username;

        $crawler = $this->client->submit($form);

        $this->assertEquals(1, $crawler->filter('span.form-error-message')->count());
    }

    /**
     * Bad values for forgot password form
     * @access public
     *
     * @return array
     */
    public function valuesForgotPassForm()
    {
        return [
            [
                ''
            ],
            [
                'InactiveUser'
            ],
            [
                'NotExistUser'
            ],
        ];
    }

    /**
     * Test path to forgot password (Home - Login - Forgot Password)
     *
     * @return void
     */
    public function testPathToForgotPass()
    {
        $crawler = $this->client->request('GET', '/');

        $loginLink = $crawler->selectLink('Sign up')->link();
        $crawler = $this->client->click($loginLink);

        $forgotLink = $crawler->selectLink('Forgot password ?')->link();
        $crawler = $this->client->click($forgotLink);

        $this->assertSame('Forgot Password', $crawler->filter('h1')->text());
    }

    /**
     * Test Reset pass method of SecurityController
     * @access public
     * @covers ::resetPassAction
     *
     * @return void
     */
    public function testResetPass()
    {
        $crawler = $this->client->request(
            'GET',
            '/reset_password/k15b26a3d01aaoo2ed2f8efe52a43d621a552be7c9821aab8238a4dc40b53e600689559629535115'
        );

        $form = $crawler->selectButton('Reset')->form();
        $form['form[email]'] = 'resetpass@email.com';
        $form['form[password]'] = 'anewsimplypass45';

        $this->client->submit($form);
        $crawler = $this->client->followRedirect();
        
        $this->assertEquals(1, $crawler->filter('div.flash-notice')->count());

        $manager = $this->client->getContainer()->get('doctrine')->getManager();
        $token = $manager
            ->getRepository(Token::class)
            ->getTokenWithUser('k15b26a3d01aaoo2ed2f8efe52a43d621a552be7c9821aab8238a4dc40b53e600689559629535115')
        ;

        $encoder = $this->client->getContainer()->get('security.password_encoder');

        $user = $manager->getRepository(User::class)->findOneByUsername('ResetPassUser');
        
        $this->assertTrue($encoder->isPasswordValid($user, 'anewsimplypass45'));
        $this->assertNull($token);
    }

    /**
     * Test Reset pass method of SecurityController with bad token
     * @access public
     * @covers ::resetPassAction
     *
     * @return void
     */
    public function testResetPassWithBadToken()
    {
        $this->client->request('GET', '/reset_password/rdfpdfpfd58978512');

        $this->assertTrue($this->client->getResponse()->isNotFound());
    }

    /**
     * Test Reset Pass method of SecurityController with bad values
     * @access public
     * @param string $email
     * @param string $pass
     * @param int $result
     * @covers ::resetPassAction
     * @dataProvider valuesResetPassForm
     *
     * @return void
     */
    public function testResetPassWithBadValues($email, $pass, $result)
    {
        $crawler = $this->client->request(
            'GET',
            '/reset_password/k15b26a3d01aaoo2ed2f8effffa42d621a554be7c9821aab8238a4dc4et53e600689486629535115'
        );

        $form = $crawler->selectButton('Reset')->form();
        $form['form[email]'] = $email;
        $form['form[password]'] = $pass;

        $crawler = $this->client->submit($form);
        
        $this->assertEquals($result, $crawler->filter('span.form-error-message')->count());     
    }

    /**
     * Bad values for reset password form
     * @access public
     *
     * @return array
     */
    public function valuesResetPassForm()
    {
        return [
            [
                '',
                '',
                2
            ],
            [
                'notgoodemail@email.com',
                'dz3',
                3
            ],
            [
                'notgoodemail@email.com',
                'vmfpdms5v7b2g6h9opemshzysickfjfhdhsklzoidzdzdzzdzdzd',
                2
            ],
        ];
    }

    /**
     * Test reset pass with an expired token
     * @access public
     *
     * @return array
     */
    public function testResetPassWithExpiredToken()
    {
        $this->client->request(
            'GET',
            '/reset_password/u15b26a3d01aaoo2ed2f8efkzfa42d621a554be8c9821aab8238a4dc4et53e6006c9482629535115'
        );

        $this->assertTrue($this->client->getResponse()->isNotFound());
    }

    /**
     * {@inheritdoc}
     */
    public function tearDown()
    {
        $this->client = null;
    }
}