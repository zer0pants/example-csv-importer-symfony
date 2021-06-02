<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class HelpController extends AbstractController
{
    /**
     * @Route("import/help")
     * @return Response
     */
    public function index(): Response
    {
        return $this->render('import/help.html.twig', []);
    }

    /**
     * @Route("import/help/sample")
     * @return Response
     */
    public function sample(ParameterBagInterface $parameterBag): BinaryFileResponse
    {
        $projectPath = $parameterBag->get('kernel.project_dir');
        $publicPath = realpath("{$projectPath}/public");

        $response = new BinaryFileResponse("{$publicPath}/assets/sample-transactions.csv");

        return $response;
    }
}
