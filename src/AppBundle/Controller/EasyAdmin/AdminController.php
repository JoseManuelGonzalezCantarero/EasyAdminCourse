<?php

namespace AppBundle\Controller\EasyAdmin;

use JavierEguiluz\Bundle\EasyAdminBundle\Controller\AdminController as BaseAdminController;

class AdminController extends BaseAdminController
{
    public function exportAction()
    {
        throw new \RuntimeException('Action for exporting an entity not defined');
    }
}
