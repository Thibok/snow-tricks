<?php

/**
 * TrickController Test
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
     * Test addAction method of TrickController
     * @access public
     * @covers ::addAction
     *
     * @return void
     */
    public function testAddTrick()
    {
        $fileDir = __DIR__.'/../uploads/';
        copy($fileDir.'trick.jpg', $fileDir.'trick-copy.jpg');
        copy($fileDir.'snow.png', $fileDir.'snow-copy.png');
        $trickDateRegex = '#^([0-9]{2}-){2}[0-9]{4} at [0-9]{2}h[0-9]{2}$#';
        $absolutePath = __DIR__.'/../../../web/';

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

        $this->assertEquals(1, $crawler->filter('div.flash-notice')->count());

        $manager = $this->client->getContainer()->get('doctrine')->getManager();
        $trick = $manager->getRepository(Trick::class)->getTrick('trick-test');

        $trickName = $trick->getName();
        $trickSlug = $trick->getSlug();
        $trickDescription = $trick->getDescription();
        $trickAddAt = $trick->getAddAt()->format('d-m-Y \a\t H\hi');
        $trickUpdateAt = $trick->getUpdateAt();
        $trickFirstThumbImg = $absolutePath . $trick->getImages()[0]->getUploadWebTestThumbPath();
        $trickSecondThumbImg = $absolutePath . $trick->getImages()[1]->getUploadWebTestThumbPath();
        $trickFirstLargeImg = $absolutePath . $trick->getImages()[0]->getUploadWebTestLargePath();
        $trickSecondLargeImg = $absolutePath . $trick->getImages()[1]->getUploadWebTestLargePath();
        $trickFirstVideo = $trick->getVideos()[0]->getUrl();
        $trickSecondVideo = $trick->getVideos()[1]->getUrl();
        $trickThirdVideo = $trick->getVideos()[2]->getUrl();
        $trickFourthVideo = $trick->getVideos()[3]->getUrl();
        $trickFifthVideo = $trick->getVideos()[4]->getUrl();
        $trickSixthVideo = $trick->getVideos()[5]->getUrl();
        $trickSeventhVideo = $trick->getVideos()[6]->getUrl();
        $trickEighthVideo = $trick->getVideos()[7]->getUrl();
        $trickCategory = $trick->getCategory()->getName();
        $trickAuthor = $trick->getUser()->getFirstName() . ' ' . $trick->getUser()->getName();

        $this->assertSame('Trick test', $trickName);
        $this->assertSame('trick-test', $trickSlug);
        $this->assertSame('BryanEnabled TestEnabled', $trickAuthor);
        $this->assertSame('A short description !', $trickDescription);
        $this->assertEquals(1, preg_match($trickDateRegex, $trickAddAt));
        $this->assertNull($trickUpdateAt);
        $this->assertTrue(file_exists($trickFirstThumbImg));
        $this->assertTrue(file_exists($trickSecondThumbImg));
        $this->assertTrue(file_exists($trickFirstLargeImg));
        $this->assertTrue(file_exists($trickSecondLargeImg));
        $this->assertSame('https://youtu.be/VZ4teZHfpkc', $trickFirstVideo);
        $this->assertSame('https://www.youtube.com/watch?v=VZ4teZHfpkc', $trickSecondVideo);
        $this->assertSame('https://www.youtube.com/embed/VZ4teZHfpkc', $trickThirdVideo);
        $this->assertSame('https://www.dailymotion.com/video/x14wofv', $trickFourthVideo);
        $this->assertSame('https://dai.ly/x14wofv', $trickFifthVideo);
        $this->assertSame('https://www.dailymotion.com/embed/video/x14wofv', $trickSixthVideo);
        $this->assertSame('https://vimeo.com/9636197', $trickSeventhVideo);
        $this->assertSame('https://player.vimeo.com/video/9636197', $trickEighthVideo);
        $this->assertSame('Grabs', $trickCategory);
    }

    /**
     * Test editAction method of TrickController
     * @access public
     * @covers ::editAction
     *
     * @return void
     */
    public function testUpdateTrick()
    {
        $fileDir = __DIR__.'/../uploads/';
        copy($fileDir.'snow.png', $fileDir.'snow-copy-1.png');
        $trickDateRegex = '#^([0-9]{2}-){2}[0-9]{4} at [0-9]{2}h[0-9]{2}$#';
        $absolutePath = __DIR__.'/../../../web/';

        $manager = $this->client->getContainer()->get('doctrine')->getManager();
        $trick = $manager->getRepository(Trick::class)->getTrick('a-very-good-trick');
        
        $this->logIn();
        $crawler = $this->client->request('GET', '/tricks/details/a-very-good-trick/update');

        $form = $crawler->selectButton('Edit')->form();
        $form['appbundle_trick[name]'] = 'New name';
        $form['appbundle_trick[description]'] = 'New description !';
        $form['appbundle_trick[videos][0][url]'] = 'https://www.youtube.com/watch?v=tHHxTHZwFUw';
        $form['appbundle_trick[videos][1][url]'] = 'https://www.dailymotion.com/video/xnltrc';
        $selectOptions = $form['appbundle_trick[category]']->availableOptionValues();
        $form['appbundle_trick[category]']->select($selectOptions[4]);
        $form['appbundle_trick[images][0][file]']->upload(
            new UploadedFile(
                __DIR__.'/../uploads/trick.jpg',
                'trick.jpg',
                'image/jpg',
                null,
                null,
                true
            )
        );
        $values = $form->getPhpValues();
        unset($values['appbundle_trick']['videos'][2]['url']);
        unset($values['appbundle_trick']['images'][1]['file']);

        $values['appbundle_trick']['videos'][2]['url'] = 'https://dai.ly/xx0pxj';
        $values['appbundle_trick']['videos'][3]['url'] = 'https://youtu.be/397Z2HrHn-4';
        $values['appbundle_trick']['videos'][4]['url'] = 'https://www.youtube.com/embed/K-RKP3BizWM';
        $values['appbundle_trick']['videos'][5]['url'] = 'https://www.dailymotion.com/embed/video/xx0pxj';
        $values['appbundle_trick']['videos'][6]['url'] = 'https://vimeo.com/14050350';
        $values['appbundle_trick']['videos'][7]['url'] = 'https://player.vimeo.com/video/4806901';

        $values['appbundle_trick']['images'][3]['file'] = new UploadedFile(
            $fileDir.'snow-copy-1.png',
            'snow-copy-1.png',
            'image/png',
            null,
            null,
            true
        );

        $this->client->request($form->getMethod(), $form->getUri(), $values, $form->getPhpFiles());
        $crawler = $this->client->followRedirect();

        $this->assertEquals(1, $crawler->filter('div.flash-notice')->count());

        $trickUpdated = $manager->getRepository(Trick::class)->getTrick('new-name');

        $trickAddAt = $trickUpdated->getAddAt()->format('d-m-Y \a\t H\hi');
        $trickUpdateAt = $trickUpdated->getUpdateAt()->format('d-m-Y \a\t H\hi');

        $this->assertSame('New name', $trickUpdated->getName());
        $this->assertSame('new-name', $trickUpdated->getSlug());
        $this->assertSame('New description !', $trickUpdated->getDescription());
        $this->assertSame('One foot tricks', $trickUpdated->getCategory()->getName());
        $this->assertEquals(1, preg_match($trickDateRegex, $trickAddAt));
        $this->assertEquals(1, preg_match($trickDateRegex, $trickUpdateAt));
        
        $this->assertSame('https://www.youtube.com/watch?v=tHHxTHZwFUw', $trickUpdated->getVideos()[0]->getUrl());
        $this->assertSame('https://www.dailymotion.com/video/xnltrc', $trickUpdated->getVideos()[1]->getUrl());
        $this->assertSame('https://dai.ly/xx0pxj', $trickUpdated->getVideos()[2]->getUrl());
        $this->assertSame('https://youtu.be/397Z2HrHn-4', $trickUpdated->getVideos()[3]->getUrl());
        $this->assertSame('https://www.youtube.com/embed/K-RKP3BizWM', $trickUpdated->getVideos()[4]->getUrl());
        $this->assertSame('https://www.dailymotion.com/embed/video/xx0pxj', $trickUpdated->getVideos()[5]->getUrl());
        $this->assertSame('https://vimeo.com/14050350', $trickUpdated->getVideos()[6]->getUrl());
        $this->assertSame('https://player.vimeo.com/video/4806901', $trickUpdated->getVideos()[7]->getUrl());

        $oldImgThumb = $absolutePath . $trick->getImages()[1]->getUploadWebTestThumbPath();
        $oldImgLarge = $absolutePath . $trick->getImages()[1]->getUploadWebTestLargePath();
        $oldImgId = $trick->getImages()[1]->getId();

        $oldImgExist = $manager->getRepository(TrickImage::class)->find($oldImgId);

        $this->assertNull($oldImgExist);
        $this->assertFalse(file_exists($oldImgThumb));
        $this->assertFalse(file_exists($oldImgLarge));

        foreach ($trickUpdated->getImages() as $newImg) {
            $this->assertTrue(file_exists($absolutePath . $newImg->getUploadWebTestThumbPath()));
            $this->asserttrue(file_exists($absolutePath . $newImg->getUploadWebTestLargePath()));
        }
    }

    /**
     * Test addAction method of TrickController with bad values
     * @access public
     * @param string $name
     * @param string $description
     * @param UploadedFile $image
     * @param string $video
     * @param int $result
     * @covers ::addAction
     * @dataProvider valuesTrickForm
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

        $this->assertEquals($result, $crawler->filter('span.form-error-message')->count());
    }

    /**
     * Test editAction method of TrickController with bad values
     * @access public
     * @param string $name
     * @param string $description
     * @param UploadedFile $image
     * @param string $video
     * @param int $result
     * @covers ::editAction
     * @dataProvider valuesTrickForm
     * 
     * @return void
     */
    public function testUpdateTrickWithBadValues($name, $description, $image, $video, $result)
    {
        $this->logIn();
        $crawler = $this->client->request('GET', '/tricks/details/a-simple-trick/update');
        $form = $crawler->selectButton('Edit')->form();

        $form['appbundle_trick[name]'] = $name;
        $form['appbundle_trick[description]'] = $description;
        $values = $form->getPhpValues();

        if ($image != '') {
            $values['appbundle_trick']['images'][0]['file'] = $image;
        }

        $values['appbundle_trick']['videos'][0]['url'] = $video;

        $crawler = $this->client->request($form->getMethod(), $form->getUri(), $values, $form->getPhpFiles());

        $this->assertEquals($result, $crawler->filter('span.form-error-message')->count());
    }

    /**
     * Form values
     * @access public
     *
     * @return array
     */
    public function valuesTrickForm()
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
     * Test path to access edit trick page
     * @access public
     *
     * @return void
     */
    public function testPathToEditTrick()
    {
        $this->logIn();

        $crawler = $this->client->request('GET', '/');

        $link = $crawler->filter('a[href="/tricks/details/a-simple-trick/update"]')->link();
        $crawler = $this->client->click($link);

        $this->assertSame(' SnowTricks - Edit A simple trick', $crawler->filter('title')->text());
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
            ],
            [
                '/tricks/details/a-simple-trick/update'
            ],
            [
                '/tricks/details/a-simple-trick/delete'
            ]
        ];
    }

    /**
     * Test if user can't access comment form if is not logged
     * @access public
     *
     * @return void
     */
    public function testUserCantAccessCommentFormIfHeIsNotAuth()
    {
        $crawler = $this->client->request('GET', '/tricks/details/a-simple-trick');
        $this->assertEquals(0, $crawler->filter('form')->count());
    }

    /**
     * Test if user can access comment form if is logged
     * @access public
     *
     * @return void
     */
    public function testUserCanAccessCommentFormIfHeIsAuth()
    {
        $this->logIn();

        $crawler = $this->client->request('GET', '/tricks/details/a-simple-trick');
        $this->assertEquals(1, $crawler->filter('form')->count());
    }

    /**
     * Test the path to trick details (Home - A simple trick details)
     * @access public
     *
     * @return void
     */
    public function testPathToViewTrick()
    {
        $crawler = $this->client->request('GET', '/');

        $link = $crawler->filter('a[href="/tricks/details/a-simple-trick"]')->link();
        $crawler = $this->client->click($link);

        $this->assertSame(' SnowTricks - A simple trick details', $crawler->filter('title')->text());
    }

    /**
     * Test viewTrick method of TrickController
     * @access public
     * @covers ::viewAction
     * 
     * @return void
     */
    public function testViewTrick()
    { 
        $commentDateRegex = '#^Add :([0-9]{2}-){2}[0-9]{4} at [0-9]{2}h[0-9]{2}min [0-9]{2}s$#';
        $trickDateRegex = '#^(Add|Update)+ : ([0-9]{2}-){2}[0-9]{4} at [0-9]{2}h[0-9]{2}$#';
        $absolutePath = __DIR__.'/../../../web';
        $crawler = $this->client->request('GET', '/tricks/details/a-simple-trick');


        $mainTrickImg = $absolutePath . $crawler->filter('#mainTrickImg')->attr('src');
        $firstPrevImg = $absolutePath . $crawler->filter('#trick-img-thumb-0')->attr('src');
        $firstVideo = $crawler->filter('#video-container-0 > span')->text();

        $trickName = $crawler->filter('#trickName')->text();
        $trickDescription = $crawler->filter('#trickDescription')->text();
        $subInfos = $crawler->filter('#trickSubInfos > li');
        $category = $subInfos->eq(0)->text();
        $trickAddAt = $subInfos->eq(1)->text();
        $trickAuthor = $subInfos->eq(2)->text();
        $trickUpdateAt = $subInfos->eq(3)->text();

        $comments = $crawler->filter('.comment');
        $firstComment = $comments->eq(0);
        $firstCommentImg = $absolutePath . $firstComment->children('img')->attr('src');
        $firstCommentUser = $crawler->filter('.comment-user-name')->eq(0)->text();
        $firstCommentContent = $crawler->filter('.comment-content')->eq(0)->text();
        $firstCommentAddAt = $crawler->filter('.comment-add-date')->eq(0)->text();
        
        $this->assertTrue(file_exists($mainTrickImg));
        $this->assertTrue(file_exists($firstPrevImg));
        $this->assertSame('https://www.youtube.com/watch?v=dSZ7_TXcEdM', $firstVideo);

        $this->assertSame('A simple trick', $trickName);
        $this->assertSame('Simple', $trickDescription);
        $this->assertSame('Flips', $category);
        $this->assertEquals(1, preg_match($trickDateRegex, $trickAddAt));
        $this->assertSame('By : BryanEnabled TestEnabled', $trickAuthor);
        $this->assertEquals(1, preg_match($trickDateRegex, $trickUpdateAt));

        $this->assertEquals(10, $comments->count());
        $this->assertTrue(file_exists($firstCommentImg));
        $this->assertSame('BryanEnabled TestEnabled', $firstCommentUser);
        $this->assertSame('Twelfth', $firstCommentContent);
        $this->assertEquals(1, preg_match($commentDateRegex, $firstCommentAddAt));
        $this->assertEquals(1, $crawler->filter('#loadMoreComment')->count());
    }

    /**
     * Test if the user can't access of the control panel (Edit-delete) on trick details page
     * if he is not logged
     * @access public
     *
     * @return void
     */
    public function testUserCantAccesEditOrDeleteTrickLinkIfHeIsNotLogged()
    {
        $crawler = $this->client->request('GET', '/tricks/details/a-simple-trick');

        $this->assertEquals(0, $crawler->filter('#mainTrickImgControls')->count());
    }

    /**
     * Test if the user can access of the control panel (Edit-delete) on trick details page
     * if he is logged
     * @access public
     *
     * @return void
     */
    public function testUserCanAccesEditOrDeleteTrickLinkIfHeIsLogged()
    {
        $this->logIn();

        $crawler = $this->client->request('GET', '/tricks/details/a-simple-trick');

        $this->assertEquals(1, $crawler->filter('#mainTrickImgControls')->count());
    }

    /**
     * Test path Trick details - Edit Trick
     * @access public
     *
     * @return void
     */
    public function testPathViewTrickToEditTrick()
    {
        $this->logIn();

        $crawler = $this->client->request('GET', '/tricks/details/a-simple-trick');
        $editLink = $crawler->filter('#editTrick')->link();
        $crawler = $this->client->click($editLink);

        $this->assertSame(' SnowTricks - Edit A simple trick', $crawler->filter('title')->text());
    }

    /**
     * Test path Trick details - Delete Trick
     * @access public
     *
     * @return void
     */
    public function testPathViewTrickToDeleteTrick()
    {
        $this->logIn();

        $crawler = $this->client->request('GET', '/tricks/details/test-path-view-to-delete');
        $deleteLink = $crawler->filter('#deleteTrick')->link();
        $this->client->click($deleteLink);
        $crawler = $this->client->followRedirect();
        
        $this->assertSame(' SnowTricks - Home', $crawler->filter('title')->text());
    }

    /**
     * Test addComment in viewAction in TrickController
     * @access public
     * @covers ::viewAction
     * 
     * @return void
     */
    public function testAddComment()
    {
        $absolutePath = __DIR__.'/../../../web';
        $commentDateRegex = '#^Add :([0-9]{2}-){2}[0-9]{4} at [0-9]{2}h[0-9]{2}min [0-9]{2}s$#';
        $this->logIn();

        $crawler = $this->client->request('GET', '/tricks/details/a-simple-trick');
        $form = $crawler->selectButton('Leave a comment')->form();
        $form['appbundle_comment[content]'] = 'Love this trick !';
        $crawler = $this->client->submit($form);

        $this->assertEquals(1, $crawler->filter('div.flash-notice')->count());

        $commentAuthor = $crawler->filter('.comment-user-name')->eq(0)->text();
        $commentContent = $crawler->filter('.comment-content')->eq(0)->text();
        $commentAddAt = $crawler->filter('.comment-add-date')->eq(0)->text();
        $commentImgSrc = $absolutePath . $crawler->filter('.comment-user-img')->eq(0)->attr('src');

        $this->assertSame('BryanEnabled TestEnabled', $commentAuthor);
        $this->assertSame('Love this trick !', $commentContent);
        $this->assertEquals(1, preg_match($commentDateRegex, $commentAddAt));
        $this->assertTrue(file_exists($commentImgSrc));
    }

    /**
     * Test addComment in viewAction in TrickController with bad values
     * @access public
     * @param string $comment
     * @covers ::viewAction
     * @dataProvider commentFormValues
     * 
     * @return void
     */
    public function testAddCommentWithBadValues($comment)
    {
        $this->logIn();

        $crawler = $this->client->request('GET', '/tricks/details/a-simple-trick');
        $form = $crawler->selectButton('Leave a comment')->form();
        $form['appbundle_comment[content]'] = $comment;

        $crawler = $this->client->submit($form);

        $this->assertEquals(1, $crawler->filter('span.form-error-message')->count());
    }

    /**
     * Bad values for testComment
     * @access public
     *
     * @return array
     */
    public function commentFormValues()
    {
        return [
            [
                ''
            ],
            [
                'v'
            ],
            [
                '<Not <a> go>o<d fo>rmat fo>r </a> comment>'
            ],
            [
                'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur volutpat consectetur pharetra.Morbi eleifend,
                eros sed iaculis fermentum, nisl diam ultrices metus,ut mollis dui justo id urna. Aliquam erat volutpat.
                Proin lacus lacus, tristidque non turpis eget,fringilla consequat mi. Vestibulum in dui sodales, lacinia odio
                sit amet,hendrerit tortor. Morbi at venenactis felis, a eleifend dui. In hachdemu habitassey plateaze dictumsitdt.
                Mauris velit lacus, blandit nec fringilla vvel, sagittis eu nullam.'
            ]
        ];
    }

    /**
     * Test deleteTrickAction
     * @access public
     * @covers ::deleteAction
     *
     * @return void
     */
    public function testDeleteTrick()
    {
        $this->logIn();

        $manager = $this->client->getContainer()->get('doctrine')->getManager();
        $trick = $manager->getRepository(Trick::class)->getTrick('a-very-bad-trick');
        $trickId = $trick->getId();
        $comment = $manager->getRepository(Comment::class)->findOneBy(array('content' => 'Top comment !'));
        $firstCommentId = $comment->getId();
        $firstVideoId = $trick->getVideos()[0]->getId();
        $firstImg = $trick->getImages()[0];
        $firstImgId = $firstImg->getId();
        $firstImgThumbPath = __DIR__.'/../../../web/' .$firstImg->getUploadWebTestThumbPath(); 
        $firstImgLargePath = __DIR__.'/../../../web/' .$firstImg->getUploadWebTestLargePath();

        $this->client->request('GET', '/tricks/details/a-very-bad-trick/delete');
        $crawler = $this->client->followRedirect();
        
        $this->assertEquals(1, $crawler->filter('div.flash-notice')->count());

        $deletedTrick = $manager->getRepository(Trick::class)->find($trickId);
        $deletedImg = $manager->getRepository(TrickImage::class)->find($firstImgId);
        $deletedVideo = $manager->getRepository(Video::class)->find($firstVideoId);
        $deletedComment = $manager->getRepository(Comment::class)->find($firstCommentId);
        $thumbImgExist = file_exists($firstImgThumbPath);
        $largeImgExist = file_exists($firstImgLargePath);

        $this->assertNull($deletedTrick);
        $this->assertNull($deletedImg);
        $this->assertNull($deletedVideo);
        $this->assertNull($deletedComment);
        $this->assertFalse($thumbImgExist);
        $this->assertFalse($largeImgExist);
    }


    /**
     * Test path Edit trick - Delete Trick
     * @access public
     *
     * @return void
     */
    public function testPathEdiTrickToDeleteTrick()
    {
        $this->logIn();

        $crawler = $this->client->request('GET', '/tricks/details/test-path-edit-to-delete/update');
        $deleteLink = $crawler->filter('#deleteTrickBtn')->link();
        $this->client->click($deleteLink);
        $crawler = $this->client->followRedirect();

        $this->assertSame(' SnowTricks - Home', $crawler->filter('title')->text());
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