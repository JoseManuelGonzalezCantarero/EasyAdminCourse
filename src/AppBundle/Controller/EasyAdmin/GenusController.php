<?php

namespace AppBundle\Controller\EasyAdmin;

class GenusController extends AdminController
{

    public function changePublishedStatusAction()
    {
        $id = $this->request->query->get('id');
        $entity = $this->em->getRepository('AppBundle:Genus')->find($id);

        $entity->setIsPublished(! $entity->getIsPublished());

        $this->em->flush();

        $this->addFlash('success', sprintf('Genus %spublished!',
            $entity->getIsPublished() ? '' : 'un'));

        return $this->redirectToRoute('easyadmin', [
            'action' => 'show',
            'entity' => $this->request->query->get('entity'),
            'id' => $id,
        ]);
    }
}
