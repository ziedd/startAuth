<?php

namespace AppBundle\Doctrine;
use Doctrine\Common\EventSubscriber;

/**
 * Created by PhpStorm.
 * User: tritux
 * Date: 27/10/17
 * Time: 14:22
 */
class HashPasswordListener implements EventSubscriber
{

     private $passwordEncoder;
    /**
     * HashPasswordListener constructor.
     */
    public function __construct(\Symfony\Component\Security\Core\Encoder\UserPasswordEncoder $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function getSubscribedEvents()
    {
        return ['prePersist','preUpdate'];
    }
    public function prePersist(\Doctrine\ORM\Event\LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        if( !$entity instanceof \AppBundle\Entity\User){
            return ;
        }
        $this->encodePassword($entity);
       $encoded = $this->passwordEncoder->encodePassword($entity,$entity->getPlainPassword());
        $entity->setPassword($encoded);

    }

    public function encodePassword(\AppBundle\Entity\User $entity)
    {
        if(!$entity->getPlainPassword())
        {
            return ;
        }
    }


    public function preUpdate(\Doctrine\ORM\Event\LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if(!$entity instanceof \AppBundle\Entity\User){
            return;
        }
        $this->encodePassword($entity);
        $em = $args->getEntityManager();
        $meta = $em->getClassMetadata(get_class($entity));
        $em->getUnitOfWork()->recomputeSingleEntityChangeSet($meta,$entity);
    }

}