<?php

namespace AppBundle\Controller\EasyAdmin;

use AppBundle\Entity\User;

class UserController extends AdminController
{

    /**
     * @param User $entity
     */
    protected function preUpdateEntity($entity)
    {
        $entity->setUpdatedAt(new \DateTime());
    }

}
