<?php

namespace App\Controller;

use App\Entity\Import;
use App\Form\Type\ImportType;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Translation\Loader\CsvFileLoader;

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
        
            // TODO get handler
            $csvData = str_getcsv($import->getObject()->getContent(), "\n");
            array_shift($csvData);
            $csvRowsArray = array_map(function ($index, $row) {
                $processedRow = str_getcsv($row, ',');
                return $processedRow;
            }, array_keys($csvData), $csvData);

            return $this->redirectToRoute('import_show', ['import_data' => $csvRowsArray]);
        }

        return $this->render('import/create.html.twig', [
            'type' => 'CSV',
            'form' => $form->createView(),
        ]);
    }

    private function handleImportData()
    {
        // TODO - temporary function here to process data from the file

    }

    public function show(Request $request): Response
    {
        return $this->render('import/show.html.twig', [
            'data' => $request->get('import_data', []),
            'type' => 'CSV',
        ]);
    }
}
