<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use PharIo\Manifest\Url;

class DropboxController extends BaseController
{
    public function authorize() {
        $appKey = '99gnuzghu3ifo82';
        $redirectUri = 'http://localhost:8080/dropbox/callback'; // Set your actual domain and route

        // Build the authorization URL
        $authorizeUrl = "https://www.dropbox.com/oauth2/authorize?"
            . "response_type=code&client_id={$appKey}&redirect_uri={$redirectUri}";

        // Redirect the user to Dropbox for authorization
        return redirect()->to($authorizeUrl,302);
    }
    public function callback()
{
    $appKey = '99gnuzghu3ifo82';
    $appSecret = 'kkpkbq258wpltwn';
    $redirectUri = 'http://localhost:8080/dropbox/callback'; // Your registered redirect URI
    
    $code = $this->request->getGet('code'); // Ensure $code is correctly populated
    

if (empty($code)) {
    die('Error: Authorization code is missing');
}

    // Check if $code is empty or not
    if (empty($code)) {
        die('Error: Authorization code is missing');
    }
    
    $ch = curl_init('https://api.dropbox.com/oauth2/token');
    $data = [
        'code' => $code,
        'grant_type' => 'authorization_code',
        'client_id' => $appKey,
        'client_secret' => $appSecret,
        'redirect_uri' => $redirectUri,
    ];
    
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    
    $response = json_decode(curl_exec($ch), true);
    curl_close($ch);
    
    if (isset($response['access_token'])) {
        $accessToken = $response['access_token'];
        var_dump($accessToken);
        // Store the access token securely, e.g., in your database
        echo 'Access Token: ' . $accessToken;
        // Redirect or show a success message to the user
    } else {
        die('Error: Failed to obtain an access token');
    }
    
}

}