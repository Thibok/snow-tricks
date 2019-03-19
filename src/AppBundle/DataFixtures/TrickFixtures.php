<?php

/**
 * Load Trick Fixtures
 */

namespace AppBundle\DataFixtures;

use AppBundle\Entity\Trick;
use AppBundle\DataFixtures\UserFixtures;
use Doctrine\Bundle\FixturesBundle\Fixture;
use AppBundle\DataFixtures\CategoryFixtures;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;

/**
 * TrickFixtures
 */
class TrickFixtures extends Fixture implements DependentFixtureInterface, ContainerAwareInterface
{
    /**
     * @var string
     */
    const TRICK_UPDATE_TEST_REFERENCE = 'trick-update-test';

    /**
     * @var string
     */
    const TRICK_VIEW_TEST_REFERENCE = 'trick-view-test';

    /**
     * @var string
     */
    const TRICK_DELETE_TEST_REFERENCE = 'trick-delete-test';

    /**
     * @var string
     */
    const TRICK_DELETE_AJAX_TEST_REFERENCE = 'trick-delete-ajax-test';

    /**
     * @var string
     */
    const TRICK_HOME_TEST_REFERENCE = 'trick-home-test';

    /**
     * @var string
     */
    const TRICK_JAPAN_AIR_DEMO_REFERENCE = 'trick-japan-air-demo';

    /**
     * @var string
     */
    const TRICK_ONE_HUNDRED_EIGHTY_DEMO_REFERENCE = 'trick-one-hundred-eighty-demo';

    /**
     * @var string
     */
    const TRICK_BACK_FLIP_DEMO_REFERENCE = 'trick-back-flip-demo';

    /**
     * @var string
     */
    const TRICK_CORK_SCREW_DEMO_REFERENCE = 'trick-cork-screw-demo';

    /**
     * @var string
     */
    const TRICK_TAIL_SLIDE_DEMO_REFERENCE = 'trick-tail-slide-demo';

    /**
     * @var string
     */
    const TRICK_ROCKET_AIR_DEMO_REFERENCE = 'trick-rocket-air-demo';

    /**
     * @var string
     */
    const TRICK_STALFISH_DEMO_REFERENCE = 'trick-stailfish-demo';

    /**
     * @var string
     */
    const TRICK_HAAKON_FLIP_DEMO_REFERENCE = 'trick-haakon-flip-demo';

    /**
     * @var string
     */
    const TRICK_TRUCK_DRIVER_DEMO_REFERENCE = 'trick-truck-driver-demo';

    /**
     * @var string
     */
    const TRICK_SEAT_BELT_DEMO_REFERENCE = 'trick-seat-belt-demo';

    /**
     * @var string
     */
    const TRICK_NOSE_GRAB_DEMO_REFERENCE = 'trick-nose-grab-demo';

    /**
     * @var string
     */
    const TRICK_TAIL_GRAB_DEMO_REFERENCE = 'trick-tail-grab-demo';

    /**
     * @var string
     */
    const TRICK_INDY_DEMO_REFERENCE = 'trick-indy-demo';

    /**
     * @var string
     */
    const TRICK_SAD_DEMO_REFERENCE = 'trick-sad-demo';

    /**
     * @var string
     */
    const TRICK_MUTE_DEMO_REFERENCE = 'trick-mute-demo';

    /**
     * Service container
     * @var ContainerInterface
     * @access private
     */
    private $container;

    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {
        $env = $this->container->get('kernel')->getEnvironment();

        if ($env == 'test') {
            $trickForUpdate = new Trick;
            $trickForUpdate->setName('A very good Trick');
            $trickForUpdate->setDescription('This trick is very hard !');
            $trickForUpdate->setUser($this->getReference(UserFixtures::ENABLED_USER_TEST_REFERENCE));
            $trickForUpdate->setCategory($this->getReference(CategoryFixtures::CATEGORY_FLIP_TEST_REFERENCE));

            $trickForView = new Trick;
            $trickForView->setName('A simple trick');
            $trickForView->setDescription('Simple');
            $trickForView->setUpdateAt(new \DateTime);
            $trickForView->setUser($this->getReference(UserFixtures::ENABLED_USER_TEST_REFERENCE));
            $trickForView->setCategory($this->getReference(CategoryFixtures::CATEGORY_FLIP_TEST_REFERENCE));

            $trickForDelete = new Trick;
            $trickForDelete->setName('A very bad trick');
            $trickForDelete->setDescription('This trick need remove !');
            $trickForDelete->setUpdateAt(new \DateTime);
            $trickForDelete->setUser($this->getReference(UserFixtures::ENABLED_USER_TEST_REFERENCE));
            $trickForDelete->setCategory($this->getReference(CategoryFixtures::CATEGORY_FLIP_TEST_REFERENCE));

            $trickForDeleteAjax = new Trick;
            $trickForDeleteAjax->setName('A very bad bad bad trick');
            $trickForDeleteAjax->setDescription('This trick need to remove with ajax !');
            $trickForDeleteAjax->setUpdateAt(new \DateTime);
            $trickForDeleteAjax->setUser($this->getReference(UserFixtures::ENABLED_USER_TEST_REFERENCE));
            $trickForDeleteAjax->setCategory($this->getReference(CategoryFixtures::CATEGORY_FLIP_TEST_REFERENCE));

            $trickPathEditDelete = new Trick;
            $trickPathEditDelete->setName('Test path edit to delete');
            $trickPathEditDelete->setDescription('Go here !');
            $trickPathEditDelete->setUpdateAt(new \DateTime);
            $trickPathEditDelete->setUser($this->getReference(UserFixtures::ENABLED_USER_TEST_REFERENCE));
            $trickPathEditDelete->setCategory($this->getReference(CategoryFixtures::CATEGORY_FLIP_TEST_REFERENCE));

            $trickPathViewDelete = new Trick;
            $trickPathViewDelete->setName('Test path view to delete');
            $trickPathViewDelete->setDescription('Go here');
            $trickPathViewDelete->setUpdateAt(new \DateTime);
            $trickPathViewDelete->setUser($this->getReference(UserFixtures::ENABLED_USER_TEST_REFERENCE));
            $trickPathViewDelete->setCategory($this->getReference(CategoryFixtures::CATEGORY_FLIP_TEST_REFERENCE));

            $firstTrickHome = new Trick;
            $firstTrickHome->setName('First trick');
            $firstTrickHome->setDescription('I am first !');
            $firstTrickHome->setUser($this->getReference(UserFixtures::ENABLED_USER_TEST_REFERENCE));
            $firstTrickHome->setCategory($this->getReference(CategoryFixtures::CATEGORY_FLIP_TEST_REFERENCE));

            $secondTrickHome = new Trick;
            $secondTrickHome->setName('Second trick');
            $secondTrickHome->setDescription('I am second !');
            $secondTrickHome->setUser($this->getReference(UserFixtures::ENABLED_USER_TEST_REFERENCE));
            $secondTrickHome->setCategory($this->getReference(CategoryFixtures::CATEGORY_FLIP_TEST_REFERENCE));

            $thirdTrickHome = new Trick;
            $thirdTrickHome->setName('Third trick');
            $thirdTrickHome->setDescription('I am third !');
            $thirdTrickHome->setUser($this->getReference(UserFixtures::ENABLED_USER_TEST_REFERENCE));
            $thirdTrickHome->setCategory($this->getReference(CategoryFixtures::CATEGORY_FLIP_TEST_REFERENCE));

            $fourthTrickHome = new Trick;
            $fourthTrickHome->setName('Fourth trick');
            $fourthTrickHome->setDescription('I am fourth !');
            $fourthTrickHome->setUser($this->getReference(UserFixtures::ENABLED_USER_TEST_REFERENCE));
            $fourthTrickHome->setCategory($this->getReference(CategoryFixtures::CATEGORY_FLIP_TEST_REFERENCE));

            $fifthTrickHome = new Trick;
            $fifthTrickHome->setName('Fifth trick');
            $fifthTrickHome->setDescription('I am fifth');
            $fifthTrickHome->setUser($this->getReference(UserFixtures::ENABLED_USER_TEST_REFERENCE));
            $fifthTrickHome->setCategory($this->getReference(CategoryFixtures::CATEGORY_FLIP_TEST_REFERENCE));

            $sixthTrickHome = new Trick;
            $sixthTrickHome->setName('Sixth trick');
            $sixthTrickHome->setDescription('I am sixth !');
            $sixthTrickHome->setUser($this->getReference(UserFixtures::ENABLED_USER_TEST_REFERENCE));
            $sixthTrickHome->setCategory($this->getReference(CategoryFixtures::CATEGORY_FLIP_TEST_REFERENCE));

            $seventhTrickHome = new Trick;
            $seventhTrickHome->setName('Seventh trick');
            $seventhTrickHome->setDescription('I am seventh !');
            $seventhTrickHome->setUser($this->getReference(UserFixtures::ENABLED_USER_TEST_REFERENCE));
            $seventhTrickHome->setCategory($this->getReference(CategoryFixtures::CATEGORY_FLIP_TEST_REFERENCE));

            $eighthTrickHome = new Trick;
            $eighthTrickHome->setName('Eighth trick');
            $eighthTrickHome->setDescription('I am eighth !');
            $eighthTrickHome->setUser($this->getReference(UserFixtures::ENABLED_USER_TEST_REFERENCE));
            $eighthTrickHome->setCategory($this->getReference(CategoryFixtures::CATEGORY_FLIP_TEST_REFERENCE));

            $ninthTrickHome = new Trick;
            $ninthTrickHome->setName('Ninth trick');
            $ninthTrickHome->setDescription('I am ninth !');
            $ninthTrickHome->setUser($this->getReference(UserFixtures::ENABLED_USER_TEST_REFERENCE));
            $ninthTrickHome->setCategory($this->getReference(CategoryFixtures::CATEGORY_FLIP_TEST_REFERENCE));

            $tenthTrickHome = new Trick;
            $tenthTrickHome->setName('Tenth trick');
            $tenthTrickHome->setDescription('I am tenth !');
            $tenthTrickHome->setUser($this->getReference(UserFixtures::ENABLED_USER_TEST_REFERENCE));
            $tenthTrickHome->setCategory($this->getReference(CategoryFixtures::CATEGORY_FLIP_TEST_REFERENCE));

            $eleventhTrickHome = new Trick;
            $eleventhTrickHome->setName('Eleventh trick');
            $eleventhTrickHome->setDescription('I am eleventh !');
            $eleventhTrickHome->setUser($this->getReference(UserFixtures::ENABLED_USER_TEST_REFERENCE));
            $eleventhTrickHome->setCategory($this->getReference(CategoryFixtures::CATEGORY_FLIP_TEST_REFERENCE));

            $twelfthTrickHome = new Trick;
            $twelfthTrickHome->setName('Twelfth trick');
            $twelfthTrickHome->setDescription('I am twelfth !');
            $twelfthTrickHome->setUser($this->getReference(UserFixtures::ENABLED_USER_TEST_REFERENCE));
            $twelfthTrickHome->setCategory($this->getReference(CategoryFixtures::CATEGORY_FLIP_TEST_REFERENCE));

            $manager->persist($trickForUpdate);

            $manager->persist($trickForView);

            $manager->persist($trickForDelete);
            $manager->persist($trickForDeleteAjax);

            $manager->persist($trickPathEditDelete);
            $manager->persist($trickPathViewDelete);

            $manager->persist($firstTrickHome);
            $manager->persist($secondTrickHome);
            $manager->persist($thirdTrickHome);
            $manager->persist($fourthTrickHome);
            $manager->persist($fifthTrickHome);
            $manager->persist($sixthTrickHome);
            $manager->persist($seventhTrickHome);
            $manager->persist($eighthTrickHome);
            $manager->persist($ninthTrickHome);
            $manager->persist($tenthTrickHome);
            $manager->persist($eleventhTrickHome);
            $manager->persist($twelfthTrickHome);
        }

        if ($env == 'dev') {
            $trickJapanAir = new Trick;
            $trickJapanAir->setName('Japan Air');
            $trickJapanAir->setDescription(
                'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus in nisl viverra, 
                malesuada purus ac, ultrices sapien. Nullam vulputate vehicula magna, in congue augue 
                consequat at.Nunc a nibh id sem vestibulum sollicitudin.');
            $trickJapanAir->setUser($this->getReference(UserFixtures::USER_DEMO_REFERENCE));
            $trickJapanAir->setCategory($this->getReference(CategoryFixtures::CATEGORY_GRAB_REFERENCE));

            $trickOneHundredEighty = new Trick;
            $trickOneHundredEighty->setName('180');
            $trickOneHundredEighty->setDescription(
                'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus in nisl viverra, 
                malesuada purus ac, ultrices sapien. Nullam vulputate vehicula magna, in congue augue 
                consequat at.Nunc a nibh id sem vestibulum sollicitudin.');
            $trickOneHundredEighty->setUser($this->getReference(UserFixtures::USER_DEMO_REFERENCE));
            $trickOneHundredEighty->setCategory($this->getReference(CategoryFixtures::CATEGORY_ROTATION_REFERENCE));

            $trickBackFlip = new Trick;
            $trickBackFlip->setName('Back Flip');
            $trickBackFlip->setDescription(
                'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus in nisl viverra, 
                malesuada purus ac, ultrices sapien. Nullam vulputate vehicula magna, in congue augue 
                consequat at.Nunc a nibh id sem vestibulum sollicitudin.');
            $trickBackFlip->setUser($this->getReference(UserFixtures::USER_DEMO_REFERENCE));
            $trickBackFlip->setCategory($this->getReference(CategoryFixtures::CATEGORY_FLIP_REFERENCE));

            $trickCorkScrew = new Trick;
            $trickCorkScrew->setName('Cork Screw');
            $trickCorkScrew->setDescription(
                'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus in nisl viverra, 
                malesuada purus ac, ultrices sapien. Nullam vulputate vehicula magna, in congue augue 
                consequat at.Nunc a nibh id sem vestibulum sollicitudin.');
            $trickCorkScrew->setUser($this->getReference(UserFixtures::USER_DEMO_REFERENCE));
            $trickCorkScrew->setCategory($this->getReference(CategoryFixtures::CATEGORY_OFFSET_ROTATION_REFERENCE));

            $trickTailSlide = new Trick;
            $trickTailSlide->setName('Tail Slide');
            $trickTailSlide->setDescription(
                'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus in nisl viverra, 
                malesuada purus ac, ultrices sapien. Nullam vulputate vehicula magna, in congue augue 
                consequat at.Nunc a nibh id sem vestibulum sollicitudin.');
            $trickTailSlide->setUser($this->getReference(UserFixtures::USER_DEMO_REFERENCE));
            $trickTailSlide->setCategory($this->getReference(CategoryFixtures::CATEGORY_SLIDE_REFERENCE));

            $trickOneFooter = new Trick;
            $trickOneFooter->setName('One Footer');
            $trickOneFooter->setDescription(
                'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus in nisl viverra, 
                malesuada purus ac, ultrices sapien. Nullam vulputate vehicula magna, in congue augue 
                consequat at.Nunc a nibh id sem vestibulum sollicitudin.');
            $trickOneFooter->setUser($this->getReference(UserFixtures::USER_DEMO_REFERENCE));
            $trickOneFooter->setCategory($this->getReference(CategoryFixtures::CATEGORY_ONE_FOOT_TRICK_REFERENCE));

            $trickRocketAir = new Trick;
            $trickRocketAir->setName('Rocket Air');
            $trickRocketAir->setDescription(
                'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus in nisl viverra, 
                malesuada purus ac, ultrices sapien. Nullam vulputate vehicula magna, in congue augue 
                consequat at.Nunc a nibh id sem vestibulum sollicitudin.');
            $trickRocketAir->setUser($this->getReference(UserFixtures::USER_DEMO_REFERENCE));
            $trickRocketAir->setCategory($this->getReference(CategoryFixtures::CATEGORY_OLD_SCHOOL_REFERENCE));

            $trickStalFish = new Trick;
            $trickStalFish->setName('Stale Fish');
            $trickStalFish->setDescription(
                'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus in nisl viverra, 
                malesuada purus ac, ultrices sapien. Nullam vulputate vehicula magna, in congue augue 
                consequat at.Nunc a nibh id sem vestibulum sollicitudin.');
            $trickStalFish->setUser($this->getReference(UserFixtures::USER_DEMO_REFERENCE));
            $trickStalFish->setCategory($this->getReference(CategoryFixtures::CATEGORY_GRAB_REFERENCE));

            $trickMacTwist = new Trick;
            $trickMacTwist->setName('Mac Twist');
            $trickMacTwist->setDescription(
                'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus in nisl viverra, 
                malesuada purus ac, ultrices sapien. Nullam vulputate vehicula magna, in congue augue 
                consequat at.Nunc a nibh id sem vestibulum sollicitudin.');
            $trickMacTwist->setUser($this->getReference(UserFixtures::USER_DEMO_REFERENCE));
            $trickMacTwist->setCategory($this->getReference(CategoryFixtures::CATEGORY_FLIP_REFERENCE));

            $trickHaakonFlip = new Trick;
            $trickHaakonFlip->setName('Haakon Flip');
            $trickHaakonFlip->setDescription(
                'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus in nisl viverra, 
                malesuada purus ac, ultrices sapien. Nullam vulputate vehicula magna, in congue augue 
                consequat at.Nunc a nibh id sem vestibulum sollicitudin.');
            $trickHaakonFlip->setUser($this->getReference(UserFixtures::USER_DEMO_REFERENCE));
            $trickHaakonFlip->setCategory($this->getReference(CategoryFixtures::CATEGORY_FLIP_REFERENCE));

            $trickTruckDriver = new Trick;
            $trickTruckDriver->setName('Truck Driver');
            $trickTruckDriver->setDescription(
                'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus in nisl viverra, 
                malesuada purus ac, ultrices sapien. Nullam vulputate vehicula magna, in congue augue 
                consequat at.Nunc a nibh id sem vestibulum sollicitudin.');
            $trickTruckDriver->setUser($this->getReference(UserFixtures::USER_DEMO_REFERENCE));
            $trickTruckDriver->setCategory($this->getReference(CategoryFixtures::CATEGORY_GRAB_REFERENCE));

            $trickSeatBelt = new Trick;
            $trickSeatBelt->setName('Seat Belt');
            $trickSeatBelt->setDescription(
                'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus in nisl viverra, 
                malesuada purus ac, ultrices sapien. Nullam vulputate vehicula magna, in congue augue 
                consequat at.Nunc a nibh id sem vestibulum sollicitudin.');
            $trickSeatBelt->setUser($this->getReference(UserFixtures::USER_DEMO_REFERENCE));
            $trickSeatBelt->setCategory($this->getReference(CategoryFixtures::CATEGORY_GRAB_REFERENCE));

            $trickNoseGrab = new Trick;
            $trickNoseGrab->setName('Nose Grab');
            $trickNoseGrab->setDescription(
                'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus in nisl viverra, 
                malesuada purus ac, ultrices sapien. Nullam vulputate vehicula magna, in congue augue 
                consequat at.Nunc a nibh id sem vestibulum sollicitudin.');
            $trickNoseGrab->setUser($this->getReference(UserFixtures::USER_DEMO_REFERENCE));
            $trickNoseGrab->setCategory($this->getReference(CategoryFixtures::CATEGORY_GRAB_REFERENCE));

            $trickTailGrab = new Trick;
            $trickTailGrab->setName('Tail grab');
            $trickTailGrab->setDescription(
                'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus in nisl viverra, 
                malesuada purus ac, ultrices sapien. Nullam vulputate vehicula magna, in congue augue 
                consequat at.Nunc a nibh id sem vestibulum sollicitudin.');
            $trickTailGrab->setUser($this->getReference(UserFixtures::USER_DEMO_REFERENCE));
            $trickTailGrab->setCategory($this->getReference(CategoryFixtures::CATEGORY_GRAB_REFERENCE));

            $trickIndy = new Trick;
            $trickIndy->setName('Indy');
            $trickIndy->setDescription(
                'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus in nisl viverra, 
                malesuada purus ac, ultrices sapien. Nullam vulputate vehicula magna, in congue augue 
                consequat at.Nunc a nibh id sem vestibulum sollicitudin.');
            $trickIndy->setUser($this->getReference(UserFixtures::USER_DEMO_REFERENCE));
            $trickIndy->setCategory($this->getReference(CategoryFixtures::CATEGORY_GRAB_REFERENCE));

            $trickSad = new Trick;
            $trickSad->setName('Sad');
            $trickSad->setDescription(
                'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus in nisl viverra, 
                malesuada purus ac, ultrices sapien. Nullam vulputate vehicula magna, in congue augue 
                consequat at.Nunc a nibh id sem vestibulum sollicitudin.');
            $trickSad->setUser($this->getReference(UserFixtures::USER_DEMO_REFERENCE));
            $trickSad->setCategory($this->getReference(CategoryFixtures::CATEGORY_GRAB_REFERENCE));

            $trickMute = new Trick;
            $trickMute->setName('Mute');
            $trickMute->setDescription(
                'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus in nisl viverra, 
                malesuada purus ac, ultrices sapien. Nullam vulputate vehicula magna, in congue augue 
                consequat at.Nunc a nibh id sem vestibulum sollicitudin.');
            $trickMute->setUser($this->getReference(UserFixtures::USER_DEMO_REFERENCE));
            $trickMute->setCategory($this->getReference(CategoryFixtures::CATEGORY_GRAB_REFERENCE));

            $manager->persist($trickJapanAir);
            $manager->persist($trickOneHundredEighty);
            $manager->persist($trickBackFlip);
            $manager->persist($trickCorkScrew);
            $manager->persist($trickTailSlide);
            $manager->persist($trickOneFooter);
            $manager->persist($trickRocketAir);
            $manager->persist($trickStalFish);
            $manager->persist($trickMacTwist);
            $manager->persist($trickHaakonFlip);
            $manager->persist($trickTruckDriver);
            $manager->persist($trickSeatBelt);
            $manager->persist($trickNoseGrab);
            $manager->persist($trickTailGrab);
            $manager->persist($trickIndy);
            $manager->persist($trickSad);
            $manager->persist($trickMute);
        }
        
        $manager->flush();

        if ($env == 'test') {
            $this->addReference(self::TRICK_UPDATE_TEST_REFERENCE, $trickForUpdate);
            $this->addReference(self::TRICK_VIEW_TEST_REFERENCE, $trickForView);
            $this->addReference(self::TRICK_DELETE_TEST_REFERENCE, $trickForDelete);
            $this->addReference(self::TRICK_DELETE_AJAX_TEST_REFERENCE, $trickForDeleteAjax);
            $this->addReference(self::TRICK_HOME_TEST_REFERENCE, $twelfthTrickHome);
        }

        if ($env == 'dev') {
            $this->addReference(self::TRICK_JAPAN_AIR_DEMO_REFERENCE, $trickJapanAir);
            $this->addReference(self::TRICK_ONE_HUNDRED_EIGHTY_DEMO_REFERENCE, $trickOneHundredEighty);
            $this->addReference(self::TRICK_BACK_FLIP_DEMO_REFERENCE, $trickBackFlip);
            $this->addReference(self::TRICK_CORK_SCREW_DEMO_REFERENCE, $trickCorkScrew);
            $this->addReference(self::TRICK_TAIL_SLIDE_DEMO_REFERENCE, $trickTailSlide);
            $this->addReference(self::TRICK_ROCKET_AIR_DEMO_REFERENCE, $trickRocketAir);
            $this->addReference(self::TRICK_STALFISH_DEMO_REFERENCE, $trickStalFish);
            $this->addReference(self::TRICK_HAAKON_FLIP_DEMO_REFERENCE, $trickHaakonFlip);
            $this->addReference(self::TRICK_TRUCK_DRIVER_DEMO_REFERENCE, $trickTruckDriver);
            $this->addReference(self::TRICK_SEAT_BELT_DEMO_REFERENCE, $trickSeatBelt);
            $this->addReference(self::TRICK_NOSE_GRAB_DEMO_REFERENCE, $trickNoseGrab);
            $this->addReference(self::TRICK_TAIL_GRAB_DEMO_REFERENCE, $trickTailGrab);
            $this->addReference(self::TRICK_INDY_DEMO_REFERENCE, $trickIndy);
            $this->addReference(self::TRICK_SAD_DEMO_REFERENCE, $trickSad);
            $this->addReference(self::TRICK_MUTE_DEMO_REFERENCE, $trickMute);
        }
    }

    /**
     * @inheritDoc
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * @inheritDoc
     */
    public function getDependencies()
    {
        return array(
            UserFixtures::class,
            CategoryFixtures::class
        );
    }
}