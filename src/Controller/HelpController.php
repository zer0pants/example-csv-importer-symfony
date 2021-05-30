<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HelpController extends AbstractController
{
    /**
     * Undocumented function
     * @Route("import/help")
     * @return Response
     */
    public function index(): Response
    {
        return $this->render('import/help.html.twig', []);
    }
}
