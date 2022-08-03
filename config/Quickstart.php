<?php

require 'vendor/autoload.php';

$client = new Google\Client();
$client->setApplicationName('Google Sheets API PHP Quickstart');
$client->setScopes('https://www.googleapis.com/auth/spreadsheets');
$client->setAuthConfig('credentials.json');
$client->setAccessType('offline');
$client->setPrompt('select_account consent');

$service = new Google\Service\Sheets($client);

function create_new_data($spreadsheetId = null, $range = null,$data = null,$service){
    try{
        $valueInputOption = 'RAW';
        
        //add the values to be appended
        //execute the request
        $body = new Google_Service_Sheets_ValueRange([
            'values' => $data
        ]);
        $params = [
            'valueInputOption' => $valueInputOption
        ];
        $insert = [
            'insertDataOption' => 'INSERT_ROWS' 
        ];
        $result = $service->spreadsheets_values->append($spreadsheetId, $range, $body, $params, $insert);
        return [
            'status' => 200,
            'Message' => 'Success'
        ];
    } catch (Exception $e) {
        // TODO(developer) - handle error appropriately
        $json = json_decode($e->getMessage())->error;
        return [
            'status' => $json->code,
            'Message' => $json->status
        ];
    }
}

// $result = create_new_data('1B0sdI4tMjs0YZ8cMrL_l3irEKZivKVE65oS9X_TldA4','Sheet2',$values,$service);
// var_dump($result);

