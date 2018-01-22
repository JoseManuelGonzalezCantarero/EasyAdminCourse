<?php

namespace AppBundle\Twig;


use AppBundle\Entity\Genus;

class EasyAdminExtension extends \Twig_Extension
{

    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter(
                'filter_admin_actions',
                [$this, 'filterActions']
            ),
        ];
    }

    public function filterActions(array $itemActions, $item)
    {
        if ($item instanceof Genus && $item->getIsPublished()) {
            unset($itemActions['delete']);
        }

        return $itemActions;
    }

}
