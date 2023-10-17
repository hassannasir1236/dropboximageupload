<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class DropboxController extends BaseController
{
    public function authorize()
    {
        $appKey = '99gnuzghu3ifo82';
        $redirectUri = 'http://localhost:8080/dropbox/callback';

        // Redirect the user to the Dropbox authorization page
        return redirect()->to(
            'https://www.dropbox.com/oauth2/authorize?' .
            http_build_query([
                'client_id' => $appKey,
                'response_type' => 'code',
                'redirect_uri' => $redirectUri,
            ])
        );
    }
    public function callback()
{
    $appKey = '99gnuzghu3ifo82';
    $appSecret = 'kkpkbq258wpltwn';
    $redirectUri = 'http://localhost:8080/dropbox/callback';

    // Get the authorization code from the query parameters
    var_dump($_GET);
    $code = $this->request->getGet('code');
    var_dump($code);
    // Use cURL to exchange the authorization code for an access token
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
    print_r($response); 

    if (isset($response['access_token'])) {
        $accessToken = $response['access_token'];
        print_r($accessToken);
        // Store the access token securely, e.g., in your database

        // Redirect or show a success message to the user
    }
}

}
