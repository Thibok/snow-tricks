<?php

namespace AppBundle\ParamConverter;

use AppBundle\Entity\Trick;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;

class TrickParamConverter implements ParamConverterInterface
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function supports(ParamConverter $configuration)
    {
        if (Trick::class === $configuration->getClass() && $configuration->getName() == 'trick') {
            return true;
        }
    }

    public function apply(Request $request, ParamConverter $configuration)
    {
        $trick = $this->em->getRepository(Trick::class)->getTrick($request->attributes->get('slug'));

        if ($trick == null) {
            throw new NotFoundHttpException();
        }

        $request->attributes->set($configuration->getName(), $trick);

        return true;
    }
}