<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RedirectByRoleController extends AbstractController
{
    /**
     * @Route("/redirectbyrole", name="redirect_by_role")
     */
    public function index(): Response
    {
        if($this->isGranted('ROLE_USER')){
            return $this->redirectToRoute('article_index');
        }
        if($this->isGranted('ROLE_ADMIN')){
            return $this->redirectToRoute('admin');

        }
        if($this->isGranted('ROLE_SUP_ADMIN')){
            return $this->redirectToRoute('admin');

        }
    }
}
