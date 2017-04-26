<?php

namespace ConferenceSchedulerBundle\ParamConverter;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Doctrine\ORM\EntityManagerInterface;

//
// services.yml
// 
//    conference.converter.class: ConferenceSchedulerBundle\ParamConverter\ConferenceParamConverter
//
//    conference.converter:
//        class: "%conference.converter.class%"
//        arguments:
//            - "@doctrine.orm.default_entity_manager"
//        tags:
//            - { name: request.param_converter, priority: -2, converter: conference.converter }

/**
 * Convert parameter to Conference entity
 * 
 * <code>
 * [at]ParamConverter("conference", converter="conference.converter")
 * </code>
 * 
 * @author Valentin Hristov <v.hristov@mail.ru>
 * @deprecated
 * 
 */
class ConferenceParamConverter implements ParamConverterInterface {

    /**
     * @var EntityManagerInterface
     */
    private $registry;

    /**
     * Construct
     * 
     * @param EntityManagerInterface $registry Manager registry
     */
    public function __construct(EntityManagerInterface $registry) {
        $this->registry = $registry;
    }

    /**
     * {@inheritdoc}
     */
    public function supports(ParamConverter $configuration) {
        // Get actual entity manager for class
        $em = $this->registry->getRepository('ConferenceSchedulerBundle:Conference');

        // Check, if class name is what we need
        if ($em->getClassName() !== 'ConferenceSchedulerBundle\Entity\Conference') {
            return false;
        }

        return true;
    }

    /**
     * {@inheritdoc}
     *
     * Applies converting
     *
     * @throws NotFoundHttpException     When object not found
     */
    public function apply(Request $request, ParamConverter $configuration) {
        
        $id = $request->attributes->get('id', null);

        // Check, if route attributes exists
        if (null === $id) {
            throw new InvalidArgumentException('Missing identifier');
        }

        $params = [
            'id' => $id,
        ];

        $entity = $this->registry
                ->getRepository($configuration->getClass())
                ->findOneBy($params);

        if (!$entity) {
            throw new NotFoundHttpException('Conference not found');
        }

        $request->attributes
                ->set($configuration->getName(), $entity);
    }

}
