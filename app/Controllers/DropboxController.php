<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use PharIo\Manifest\Url;

class DropboxController extends BaseController
{
    private $appKey = '99gnuzghu3ifo82';
    private $appSecret = 'kkpkbq258wpltwn';
   private $redirectUri = 'http://localhost:8080/dropbox/callback';

    public function authorize() {
        $appKey = '99gnuzghu3ifo82';
        $redirectUri = 'http://localhost:8080/dropbox/callback'; // Set your actual domain and route

        // Build the authorization URL
        $authorizeUrl = "https://www.dropbox.com/oauth2/authorize?"
            . "response_type=code&client_id={$this->appKey}&redirect_uri={$this->redirectUri}";

        // Redirect the user to Dropbox for authorization
        return redirect()->to($authorizeUrl,302);
    }
    public function callback()
{
    $accessToken = '';
    $refreshtoken = '';
    // $appKey = '99gnuzghu3ifo82';
    // $appSecret = 'kkpkbq258wpltwn';
    // $redirectUri = 'http://localhost:8080/dropbox/callback'; // Your registered redirect URI
    
    $code = $this->request->getGet('code'); // Ensure $code is correctly populated
    

    $ch = curl_init('https://api.dropbox.com/oauth2/token');
    $data = [
        'code' => $code,
        'grant_type' => 'authorization_code',
        'client_id' => $this->appKey,
        'client_secret' => $this->appSecret,
        'redirect_uri' => $this->redirectUri,
    ];
    
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    
    $response = json_decode(curl_exec($ch), true);
    curl_close($ch);
    $session = service('session');

// Set session data
$session->set('access_token', $response['access_token']);
    // print_r($response);
    if (isset($response['access_token'])) {
        $refreshToken = $response['access_token'];
        print_r($refreshToken);
        echo "<br>";
     
        // Store the refresh token securely for future use.
    } else {
        print_r('Error token is not get');
        // Handle the error if the refresh token is not provided in the response.
    }
}

public function refreshToken() {
    // You should securely store the refresh token.
    $session = service('session');
    $refreshToken = $session->get('access_token');
     // Your registered redirect URI
    
    // Prepare data for token refresh
    $tokenUrl = 'https://api.dropbox.com/oauth2/token';
    $data = [
        'grant_type' => 'refresh_token',
        'refresh_token' => $refreshToken,
        'client_id' => $this->appKey,
        'client_secret' => $this->appSecret,
    ];

    // Send a POST request to refresh the token
    $ch = curl_init($tokenUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

    $response = json_decode(curl_exec($ch), true);
    curl_close($ch);
    print_r($response);
    
    // Check if a new access token is obtained
    if (isset($response['access_token'])) {
        $newAccessToken = $response['access_token'];
        Print_r($newAccessToken);
        // Use the new access token for API requests.
    } else {
        die('Error: Failed to refresh the access token');
    }
}

}