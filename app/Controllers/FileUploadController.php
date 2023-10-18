<?php
namespace App\Controllers;

class FileUploadController extends BaseController {
    public function __construct() {
        // Load any necessary libraries here
    }

    public function index() {
        return view('upload_form');
    }

    public function upload() {
        // Load the Dropbox API library (you may need to download the Dropbox PHP SDK)
        require_once ROOTPATH . 'vendor/dropbox/dropbox-sdk/lib/Dropbox/autoload.php';

        $appKey = 'YOUR_APP_KEY';
        $appSecret = 'YOUR_APP_SECRET';
        $accessToken = 'YOUR_ACCESS_TOKEN';

        $appInfo = \Dropbox\AppInfo::loadFromJson([
            'key' => $appKey,
            'secret' => $appSecret,
        ]);

        $webAuth = new \Dropbox\WebAuthNoRedirect($appInfo, "YOUR_APP");

        $dbx = new \Dropbox\Client($accessToken, "YOUR_APP");

        // Handle file uploads using Dropzone
        $targetDir = WRITEPATH . 'uploads/';
        $targetFile = $targetDir . $_FILES['file']['name'];

        move_uploaded_file($_FILES['file']['tmp_name'], $targetFile);

        // Upload the file to Dropbox
        $file = file_get_contents($targetFile);

        $result = $dbx->uploadFile('/' . $_FILES['file']['name'], \Dropbox\WriteMode::force(), $file);

        // Handle the result or any additional actions

        // Output response or redirect to a success page
        $response = json_encode(['message' => 'File uploaded successfully.']);
        return $response;
    }
}
