<?php

namespace App\Controllers;
use Dropbox\Client;
use \Dropbox as dbx;
class Home extends BaseController
{
    public function index()
    { $accessToken = 'sl.BoDhqumALgA8gIp631Z6L68_xamh1tkUVXqfRjLNwCnDSwAMvKVpZdsqMLclm-scXXb-1YY7O3hZ7f-acIf2PH93iswpf90zXD3WJCc7NLiozmGh_gFCG4Bjt418DKdsPB8EUg0_Sz-LBwILevEK';
        
        // Dropbox folder path
        $dropboxFolderPath = '/path/to/dropbox/folder/';

        $ch = curl_init("https://api.dropboxapi.com/2/files/list_folder");
        // 'https://content.dropboxapi.com/2/files/download';
        
        $ch = curl_init("https://api.dropboxapi.com/2/files/list_folder");

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
        curl_close($ch);

        $images = [];
        foreach ($response['entries'] as $entry) {
            if (isset($entry['name']) && is_string($entry['name']) && $entry['.tag'] === 'file') {
                // Fetch image content for each file
                $path[]=$entry['path_display'];
                $imageContent = $this->fetchImageContent($accessToken, $entry['path_display']);
                $images[] = 'data:image/jpeg;base64,' . base64_encode($imageContent);
            }
        }
        if(!empty($path)){
            return view('welcome_message',  ['images' => $images,'path' => $path]);
        }else{
            return view('welcome_message');
        }
     
        
    }
    private function fetchImageContent($accessToken, $path)
    {
        $ch = curl_init("https://content.dropboxapi.com/2/files/download");

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $accessToken,
            'Dropbox-API-Arg: ' . json_encode(['path' => $path]),
        ]);

        $imageContent = curl_exec($ch);
        curl_close($ch);

        return $imageContent;
    }
    public function store(){ 
        $accessToken = 'sl.BoBS0fouBp3ZeJdLH4lFZm4-gLejbJyC6Zc_HLkSysoLa6Vmw0rfUdbfNFVmtwwhNeWCG0goy4E1p6WdvrF4ZHUO_hL5MVcxT8Fi5I1XEqW9bmYlyTRvgmBO6wxZ0xylnDTzD_iZno1rIHSUJlGu';
        
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
            return redirect('/');
          
        }
    }
    public function fetchImage()
    {
        // Dropbox access token
        $accessToken = 'sl.BoDhqumALgA8gIp631Z6L68_xamh1tkUVXqfRjLNwCnDSwAMvKVpZdsqMLclm-scXXb-1YY7O3hZ7f-acIf2PH93iswpf90zXD3WJCc7NLiozmGh_gFCG4Bjt418DKdsPB8EUg0_Sz-LBwILevEK';
       
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
    public function deleteImage()
    {
        // Check if it's an AJAX request
        if ($this->request->isAJAX()) {
            $accessToken = 'sl.BoDhqumALgA8gIp631Z6L68_xamh1tkUVXqfRjLNwCnDSwAMvKVpZdsqMLclm-scXXb-1YY7O3hZ7f-acIf2PH93iswpf90zXD3WJCc7NLiozmGh_gFCG4Bjt418DKdsPB8EUg0_Sz-LBwILevEK';
            $dropboxImagePath = $this->request->getPost('imagePath'); // Get the image path from the POST data
            // Delete the image from Dropbox
            $result = $this->deleteImageFromDropbox($accessToken, $dropboxImagePath);

            // Return a response to the client
            if ($result === true) {
                return $this->response->setJSON(['success' => true,'dropimage'=> $dropboxImagePath ]);
            } else {
                return $this->response->setJSON(['error' => 'Failed to delete image','dropimage'=>$dropboxImagePath ]);
            }
        }
    }
    private function deleteImageFromDropbox($accessToken, $path)
    {
        $ch = curl_init("https://api.dropboxapi.com/2/files/delete_v2");

        $requestData = json_encode([
            'path' => $path,
        ]);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $requestData);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $accessToken,
            'Content-Type: application/json',
        ]);

        $response = json_decode(curl_exec($ch), true);
        curl_close($ch);

        return isset($response['metadata']);
    }
    
}