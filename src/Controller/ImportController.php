<?php

namespace App\Controller;

use App\Entity\Import;
use App\Form\Type\ImportType;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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
            $content = $import->getObject()->getContent();
            $sanitizedContent = preg_replace('/[\x1F\x80-\xFF]/', '', $content);

            $csvRows = str_getcsv($sanitizedContent, "\n");

            // Handle header
            $headerArray = str_getcsv(array_shift($csvRows), ',');
            $keys = array_map('mb_strtolower', $headerArray);

            $csvRowsArray = array_map(function ($index, $row) use ($keys) {
                $processedRow = str_getcsv($row, ',');
                return array_combine($keys, $processedRow);
            }, array_keys($csvRows), $csvRows);


            $processedData = $this->handleImportData($csvRowsArray);

            return $this->redirectToRoute('import_show', ['import_data' => $processedData]);
        }

        return $this->render('import/create.html.twig', [
            'type' => 'CSV',
            'form' => $form->createView(),
        ]);
    }

    private function handleImportData(array $data): array
    {
        usort($data, function (array $a, array $b) {
            $dateA = strtotime($a['date']);
            $dateB = strtotime($b['date']);

            return $dateA <=> $dateB;
        });

        foreach($data as $key => $datem)
        {
            $data[$key]['valid'] = $this->verifyKey($datem['transactionnumber']);
            $data[$key]['type'] = $this->checkTransactionType($datem['amount']);
        }

        return $data;
    }

    private function verifyKey(string $key): bool
    {
        if (strlen($key) != 10)
        {
            return false;
        }
        
        $checkDigit = $this->generateCheckCharacter(substr(mb_strtoupper($key), 0, 9));
        return $key[9] == $checkDigit;
    }

    const VALID_CHARS = ['2', '3', '4', '5', '6', '7', '8', '9', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'J', 'K','L', 'M', 'N', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];

    private function generateCheckCharacter(string $input): string
    {
        $factor = 2;
        $sum = 0;
        $n = count(self::VALID_CHARS);

        // Starting from the right and working leftwards is easier since // the initial "factor" will always be "2"
        for ($i = strlen($input) - 1; $i >= 0; $i--)
        {
            $codePoint = array_search($input[$i], self::VALID_CHARS);
            $addend = $factor * $codePoint;
            // Alternate the "factor" that each "codePoint" is multiplied by factor = (factor == 2) ? 1 : 2;
            $factor = ($factor == 2) ? 1 : 2;
            // Sum the digits of the "addend" as expressed in base "n" addend = (addend / n) + (addend % n);
            $addend = ($addend / $n) + ($addend % $n);
            $sum += $addend;
        }
        
        // Calculate the number that must be added to the "sum" // to make it divisible by "n"
        $remainder = $sum % $n;
        $checkCodePoint = ($n - $remainder) % $n;
        
        return self::VALID_CHARS[$checkCodePoint];
    }

    private function checkTransactionType(float $amount): string
    {
        return $amount < 0 ? 'debit' : 'credit';
    }

    public function show(Request $request): Response
    {
        return $this->render('import/show.html.twig', [
            'data' => $request->get('import_data', []),
            'type' => 'CSV',
        ]);
    }
}
