<?php

namespace App\Controller;

use App\Entity\Import;
use App\Form\Type\ImportType;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class ImportController extends AbstractController
{
    /**
     * @return Response
     */
    public function create(Request $request): Response
    {
        $import = new Import();
        $form = $this->createForm(ImportType::class, $import);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $import = $form->getData();
            $todo = null;
            return $this->redirectToRoute('import_show');
        }

        return $this->render('import/create.html.twig', [
            'type' => 'CSV',
            'form' => $form->createView(),
        ]);
    }

    public function show(Request $request): Response
    {
        return $this->render('import/show.html.twig', [
            'data' => $request->data ?? [],
            'type' => 'CSV',
        ]);
    }
}
