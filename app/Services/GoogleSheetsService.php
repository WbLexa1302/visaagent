<?php

namespace App\Services;

use Google\Client;
use Google\Service\Sheets;

class GoogleSheetsService
{
    protected Client $client;
    protected Sheets $service;
    protected string $spreadsheetId;

    public function __construct()
    {
        $this->client = new Client();
        $this->client->setAuthConfig(storage_path('app/google/service-account.json'));
        $this->client->addScope(Sheets::SPREADSHEETS_READONLY);

        $this->service  = new Sheets($this->client);
        $this->spreadsheetId = config('services.google_sheets.spreadsheet_id');
    }

    public function getSheetData(string $range = 'Sheet1!A:Z'): array
    {
        $response = $this->service->spreadsheets_values->get(
            $this->spreadsheetId,
            $range
        );

        $values = $response->getValues();

        if (empty($values)) {
            return [];
        }

        // Baris pertama = header kolom
        $headers = array_map('strtolower', array_map('trim', $values[0]));
        $data = [];

        for ($i = 1; $i < count($values); $i++) {
            $row  = $values[$i];
            $item = [];
            foreach ($headers as $index => $header) {
                $item[$header] = $row[$index] ?? null;
            }
            $item['_row_index'] = $i + 1;
            $data[] = $item;
        }

        return $data;
    }
}
