<?php

namespace App\Controller;

use App\Form\Type\ImportCsvType;
use App\Module\Import\ImportHandler;
use App\Module\Transaction\TransactionRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ImportController extends AbstractController
{
    public function create(Request $request): Response
    {
        $form = $this->createForm(ImportCsvType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $import = $form->getData();
        
            $handler = new ImportHandler($import);
            $data = $handler->handle();

            usort($data, [TransactionRepository::class, 'sortTransactionByDate']);

            return $this->show($request, $data);
        }

        return $this->render('import/create.html.twig', [
            'form' => $form->createView(),
            'type' => 'CSV',
        ]);
    }

    public function show(Request $request, array $data = []): Response
    {
        return $this->render('import/show.html.twig', [
            'data' => $data,
            'type' => 'CSV',
        ]);
    }
}
