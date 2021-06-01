<?php

namespace App\Module\Import;

use App\Module\Transaction\Transaction;
use App\Module\Transaction\TransactionObjectFactory;
use App\Module\Transaction\TransactionVerificationHandler;
use DateTime;

class ImportCsv extends ImportObject 
{
    public function import(): array
    {
        $content = $this->getObject()->getContent();
        $sanitizedContent = preg_replace('/[\x1F\x80-\xFF]/', '', $content);

        $csvRows = str_getcsv($sanitizedContent, "\n");

        // Remove header row
        array_shift($csvRows);

        $csvRowsArray = array_map(function ($row) {
            return str_getcsv($row, ',');
        }, $csvRows);

        return $this->mapToTransaction($csvRowsArray);
    }

    public function mapToTransaction(array $data): array
    {
        $verificationHandler = new TransactionVerificationHandler();
        $transactionFactory = new TransactionObjectFactory($verificationHandler);
     
        $transactions = [];
        foreach ($data as $row) {
            $transactions[] = $transactionFactory->create($row[0], $row[1], $row[2], $row[3], $row[4]);
        }

        return $transactions;
    }
}
