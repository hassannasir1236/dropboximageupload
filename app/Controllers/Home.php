<?php

namespace App\Controllers;
use Dropbox\Client;
use \Dropbox as dbx;
class Home extends BaseController
{
    public function index(): string
    {
        return view('welcome_message');
    }
    public function store(){ 
        $accessToken = 'sl.BntOlx9qWjjh-kFN9VtSWDDTa1jfjfR-zZyPrfS2tGHRTu4YEzw6i63fG2H-d6NH6Yy0EgTBDz0m3xd3byJ0KIb0_vIfLG2pOigtTcJGExFkPNhoeYwNPiYgk64tohRzaRxMZxDigmhPBok7kiD0';
        // Replace 'your-access-token' with your Dropbox access token
        // $file = $this->request->getFile('image'); // Assuming your input field name is 'image'

        // if ($file->isValid() && !$file->hasMoved()) {
        //     $path = '/images/' . $file->getName(); // Set the path in Dropbox
        //     print($path);
        //    // Dropbox API endpoint
        //    $url = 'https://www.dropbox.com/scl/fo/erznl15i1zsts09tzro57/h?rlkey=3dac732h7f6jr3411lxpwyk6m&dl=0';

        //     $headers = [
        //         'Authorization: Bearer ' . $accessToken,
        //         'Content-Type: application/octet-stream',
        //         'Dropbox-API-Arg: {"path":"' . $path . '","mode":"add"}',
        //     ];
        //     print_r($headers);
        //     // Read the file contents
        //     $fileContent = file_get_contents($file->getTempName());

        //     // Make an HTTP POST request to upload the file to Dropbox
        //     $ch = curl_init($url);
        //     curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        //     curl_setopt($ch, CURLOPT_POST, true);
        //     curl_setopt($ch, CURLOPT_POSTFIELDS, $fileContent);
        //     curl_exec($ch);
        //     if($ch){
        //         echo 'Image uploaded to Dropbox!';
        //     }
           
        // } else {
        //     echo 'Image upload failed.';
        // }
        // $filePath = $_FILES['image']['tmp_name']; // Path to the uploaded image https://content.dropboxapi.com/2/files/upload







                //         $filePath = $this->request->getFile('image');

        //     $uploadPath = 'https://www.dropboxapi.com/home/Apps/uploadmultipleimages'; // Destination path in Dropbox

        //     $ch = curl_init('https://content.dropboxapi.com/2/files/upload');
            
        //     curl_setopt($ch, CURLOPT_HTTPHEADER, [
        //         'Authorization: Bearer ' . $accessToken,
        //         'Content-Type: application/octet-stream',
        //         'Dropbox-API-Arg: {"path":"' . $uploadPath . '","mode":"add"}',
        //     ]);
        //     curl_setopt($ch, CURLOPT_POST, true);
        //    curl_setopt($ch, CURLOPT_POSTFIELDS, file_get_contents($filePath));
        
        //     $response = curl_exec($ch);
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
            // if($response){
            //     echo "image save";
            //         }
            // // curl_close($ch);
            // }
        }
    }
}