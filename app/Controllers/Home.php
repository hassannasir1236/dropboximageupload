<?php

namespace App\Controllers;
use Dropbox\Client;
use \Dropbox as dbx;
class Home extends BaseController
{
    public function index()
    { $accessToken = 'sl.BnyX8tZ4MoG6srhy06tZqpZrQA7IGI9N4C6zatJwbMDdswx2aSOFipPYQ4onYQKAQudAAb4SMkvRDG75JPTMgokhiK0seJWm3gl99dTa4PAmBf06qLra2DT5x1E01rqj_2QpOuH1xX5EKHSqcrRM';
        
        // Dropbox folder path
        $dropboxFolderPath = '/path/to/dropbox/folder/';

        $ch = curl_init("https://api.dropboxapi.com/2/files/list_folder");
        // 'https://content.dropboxapi.com/2/files/download';

        $requestData = json_encode([
            'path' => $dropboxFolderPath,
        ]);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $requestData);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $accessToken,
            'Content-Type: application/json',
        ]);

        $response = json_decode(curl_exec($ch), true);
        // curl_close($ch);

        $images = [];
        print_r($response);
        foreach ($response['entries'] as $entry) {
            if (isset($entry['name']) && is_string($entry['name']) && $entry['.tag'] === 'file') {
                $images[] = 'https://www.dropbox.com/home/Apps/uploadmultipleimages/path/to/dropbox/folder?is_backup=False&preview='.$entry['name'];
            }
        }      // Initialize cURL
        //  $ch = curl_init("https://api.dropboxapi.com/2/files/list_folder");

        //  // Define the request data
        //  $requestData = json_encode([
        //      'path' => $dropboxFolderPath,
        //  ]);
 
        //  // Set cURL options
        //  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        //  curl_setopt($ch, CURLOPT_POSTFIELDS, $requestData);
        //  curl_setopt($ch, CURLOPT_HTTPHEADER, [
        //      'Authorization: Bearer ' . $accessToken,
        //      'Content-Type: application/json',
        //  ]);
 
        //  // Execute cURL request
        //  $response = curl_exec($ch);
 
        //  // Close cURL session
        //  curl_close($ch);
 
        //  // Parse the JSON response
        //  $files = json_decode($response, true);
 
         return view('welcome_message',  ['images' => $images]);
    }
    public function store(){ 
        $accessToken = 'sl.BnyX8tZ4MoG6srhy06tZqpZrQA7IGI9N4C6zatJwbMDdswx2aSOFipPYQ4onYQKAQudAAb4SMkvRDG75JPTMgokhiK0seJWm3gl99dTa4PAmBf06qLra2DT5x1E01rqj_2QpOuH1xX5EKHSqcrRM';
        
        $file = $this->request->getFile('image');

        if ($file->isValid() && $file->getSize() > 0) {
            //$accessToken = 'YOUR_DROPBOX_ACCESS_TOKEN'; // Replace with your Dropbox access token
            $fileContents = file_get_contents($file->getPathname());
            $fileName = $file->getName();

            $ch = curl_init('https://content.dropboxapi.com/2/files/upload');
            $headers = [
                'Authorization: Bearer ' . $accessToken,
                'Dropbox-API-Arg: {"path":"/path/to/dropbox/folder/' . $fileName . '"}',
                'Content-Type: application/octet-stream',
            ];

            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fileContents);

            $response = curl_exec($ch);

            if (curl_errno($ch)) {
                return 'Error: ' . curl_error($ch);
            }

            curl_close($ch);
          
        }
    }
    public function fetchImage()
    {
        // Dropbox access token
        $accessToken = 'sl.BnyX8tZ4MoG6srhy06tZqpZrQA7IGI9N4C6zatJwbMDdswx2aSOFipPYQ4onYQKAQudAAb4SMkvRDG75JPTMgokhiK0seJWm3gl99dTa4PAmBf06qLra2DT5x1E01rqj_2QpOuH1xX5EKHSqcrRM';
       
        // Dropbox file path
        $dropboxFilePath = '/path/to/dropbox/folder/download.jpg';

        // Dropbox API URL
        $apiUrl = 'https://content.dropboxapi.com/2/files/download';

        // Initialize cURL
        $ch = curl_init();

        // Set cURL options
        curl_setopt($ch, CURLOPT_URL, $apiUrl);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $accessToken,
            'Dropbox-API-Arg: {"path":"' . $dropboxFilePath . '"}',
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Execute the cURL request
        $imageContent = curl_exec($ch);

        // Close the cURL session
        curl_close($ch);

        // Display the image
        header('Content-Type: image/jpeg');
        echo $imageContent;
    }
    // public function listImages()
    // {
    //     // Dropbox access token
    //     $accessToken = 'sl.BnyrXX1sdR2WFbotrxjs5P3SCLGIrddovNyxaaYbYiG23XFHm-jB3es0gs08wEtSHX3AFqNpkqXIkN2VVHiISyznqYM7u_Xr_tnEFFe_EbqTPLLhK0AHJeGFqDijm5G3lJF2lgohJc7-KCXmYYIu';
        
    //     // Dropbox folder path
    //     $dropboxFolderPath = '/path/to/dropbox/folder/';

    //     // Dropbox API endpoint
    //     $apiUrl = 'https://api.dropboxapi.com/2/files/list_folder';

    //     // Define the request parameters
    //     $requestBody = json_encode([
    //         'path' => $dropboxFolderPath,
    //         'recursive' => false,
    //     ]);

    //     // Initialize cURL
    //     $ch = curl_init();

    //     // Set cURL options
    //     curl_setopt($ch, CURLOPT_URL, $apiUrl);
    //     curl_setopt($ch, CURLOPT_HTTPHEADER, [
    //         'Authorization: Bearer ' . $accessToken,
    //         'Content-Type: application/json',
    //     ]);
    //     curl_setopt($ch, CURLOPT_POST, true);
    //     curl_setopt($ch, CURLOPT_POSTFIELDS, $requestBody);
    //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    //     // Execute the cURL request
    //     $response = curl_exec($ch);

    //     // Close the cURL session
    //     curl_close($ch);

    //     // Decode the JSON response
    //     $data = json_decode($response, true);
    //     print_r($data);
    //     // Pass the data to the view
    //     return view('welcome_message', ['data' => $data]);
    // }
}