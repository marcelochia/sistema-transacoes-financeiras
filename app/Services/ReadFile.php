<?php

namespace App\Services;

class ReadFile
{
    public function process($file): array
    {
        $transactions = [];

        if ($file->getMimeType() === 'text/csv') {
            $transactions = $this->processCsv($file);
        }

        if ($file->getMimeType() === 'text/xml') {
            $transactions = $this->processXml($file);
        }

        return $transactions;
    }

    private function processCsv($file): array
    {
        $content = fopen($file, "r");

        $transactions = [];
        $transactions['dateTransaction'] = '';

        while (($transaction = fgetcsv($content))) {
            if ($transactions['dateTransaction'] === '') {
                $transactions['dateTransaction'] = substr($transaction[7], 0, 10);
            }

            $hasEmptyField = $this->emptyField($transaction);

            if (!$hasEmptyField && $transactions['dateTransaction'] === substr($transaction[7], 0, 10)) {
                $transactions[] = $transaction;
            }
        }

        fclose($content);

        return $transactions;
    }

    private function processXml($file): array
    {
        $xml = simplexml_load_string($file->getContent());
        
        $transactions = [];
        $transactions['dateTransaction'] = '';

        foreach ($xml->transacao as $transacao) {
            $transaction = [];
            
            if ($transactions['dateTransaction'] === '') {
                $transactions['dateTransaction'] = substr($transacao->data, 0, 10);
            }

            foreach ($transacao->origem as $origem) {
                $transaction[] = (string)$origem->banco;
                $transaction[] = (string)$origem->agencia;
                $transaction[] = (string)$origem->conta;
            }

            foreach ($transacao->destino as $destino) {
                $transaction[] = (string)$destino->banco;
                $transaction[] = (string)$destino->agencia;
                $transaction[] = (string)$destino->conta;
            }

            $transaction[] = (string)$transacao->valor;
            $transaction[] = (string)$transacao->data;
            
            $hasEmptyField = $this->emptyField($transaction);
            
            if (!$hasEmptyField && substr($transaction[7], 0 , 10) === $transactions['dateTransaction']) {
                $transactions[] = $transaction;
            }
        }

        return $transactions;
    }

    private function emptyField(array $transaction): bool
    {
        for ($i=0; $i < count($transaction) ; $i++) {
            if ($transaction[$i] === '') {
                return true;
            }
        }
        
        return false;
    }
}
