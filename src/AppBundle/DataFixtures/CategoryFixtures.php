<?php

/**
 * Category Fixtures
 */

namespace AppBundle\DataFixtures;

use AppBundle\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * UserFixtures
 */
class CategoryFixtures extends Fixture
{
    /**
     * @var string
     */
    const CATEGORY_FLIP_REFERENCE = 'category-flip';

    /**
     * Load fixtures
     * @access public
     * @param ObjectManager $manager
     * 
     * @return void
     */
    public function load(ObjectManager $manager)
    {
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

        $this->addReference(self::CATEGORY_FLIP_REFERENCE, $flip);
    }
}