<?php

/**
 * Convert slug to a Trick entity
 */

namespace AppBundle\ParamConverter;

use AppBundle\Entity\Trick;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;

/**
 * TrickParamConverter
 */
class TrickParamConverter implements ParamConverterInterface
{
    /**
     * @var EntityManagerInterface
     * @access private
    */
    private $manager;

    /**
     * Constructor
     * @access public
     * @param EntityManagerInterface $manager
     * 
     * @return void
     */
    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    /**
     * {@inheritdoc}
     */
    public function supports(ParamConverter $configuration)
    {
        if (Trick::class === $configuration->getClass() && $configuration->getName() == 'trick') {
            return true;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function apply(Request $request, ParamConverter $configuration)
    {
        $trick = $this->manager->getRepository(Trick::class)->getTrick($request->attributes->get('slug'));

        if ($trick == null) {
            throw new NotFoundHttpException();
        }

        $request->attributes->set($configuration->getName(), $trick);

        return true;
    }
}