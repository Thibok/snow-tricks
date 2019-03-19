<?php

/**
 * Load Category Fixtures
 */

namespace AppBundle\DataFixtures;

use AppBundle\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;

/**
 * CategoryFixtures
 */
class CategoryFixtures extends Fixture implements ContainerAwareInterface
{
    /**
     * @var string
     */
    const CATEGORY_FLIP_TEST_REFERENCE = 'category-flip-test';

    /**
     * @var string
     */
    const CATEGORY_FLIP_REFERENCE = 'category-flip';

    /**
     * @var string
     */
    const CATEGORY_GRAB_REFERENCE = 'category-grab';

    /**
     * @var string
     */
    const CATEGORY_ROTATION_REFERENCE = 'category-rotation';

    /**
     * @var string
     */
    const CATEGORY_OFFSET_ROTATION_REFERENCE = 'category-offset-rotation';

    /**
     * @var string
     */
    const CATEGORY_SLIDE_REFERENCE = 'category-slide';

    /**
     * @var string
     */
    const CATEGORY_ONE_FOOT_TRICK_REFERENCE = 'category-one-foot-trick';

    /**
     * @var string
     */
    const CATEGORY_OLD_SCHOOL_REFERENCE = 'category-old-school';

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

        $grab = new Category;
        $rotation = new Category;
        $flip = new Category;
        $offsetRotation = new Category;
        $slide = new Category;
        $oneFootTricks = new Category;
        $oldSchool = new Category;

        $grab->setName('Grabs');
        $rotation->setName('Rotations');
        $flip->setName('Flips');
        $offsetRotation->setName('Offset rotations');
        $slide->setName('Slides');
        $oneFootTricks->setName('One foot tricks');
        $oldSchool->setName('Old School');

        $manager->persist($grab);
        $manager->persist($rotation);
        $manager->persist($flip);
        $manager->persist($offsetRotation);
        $manager->persist($slide);
        $manager->persist($oneFootTricks);
        $manager->persist($oldSchool);

        $manager->flush();

        if ($env == 'test') {
            $this->addReference(self::CATEGORY_FLIP_TEST_REFERENCE, $flip);
        }

        if ($env == 'dev') {
            $this->addReference(self::CATEGORY_GRAB_REFERENCE, $grab);
            $this->addReference(self::CATEGORY_ROTATION_REFERENCE, $rotation);
            $this->addReference(self::CATEGORY_FLIP_REFERENCE, $flip);
            $this->addReference(self::CATEGORY_OFFSET_ROTATION_REFERENCE, $offsetRotation);
            $this->addReference(self::CATEGORY_SLIDE_REFERENCE, $slide);
            $this->addReference(self::CATEGORY_ONE_FOOT_TRICK_REFERENCE, $oneFootTricks);
            $this->addReference(self::CATEGORY_OLD_SCHOOL_REFERENCE, $oldSchool);
        }
    }

    /**
     * @inheritDoc
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
}