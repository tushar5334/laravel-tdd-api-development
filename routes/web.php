<?php

use Google\Client;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/drive', function () {
    $client = new Client();
    $client->setClientId('555981279342-3rh1ie4mg3td29448iujksqu316jbbhq.apps.googleusercontent.com');
    $client->setClientSecret('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');
    $client->setRedirectUri('http://localhost:8000/google-drive/callback');
    $client->setScopes([
        'https://www.googleapis.com/auth/drive',
        'https://www.googleapis.com/auth/drive.file',
    ]);
    $url = $client->createAuthUrl();
    //return $url;
    return redirect($url);
});

Route::get('/google-drive/callback', function () {
    return request('code');
    /* $client = new Client();
    $client->setClientId('555981279342-3rh1ie4mg3td29448iujksqu316jbbhq.apps.googleusercontent.com');
    $client->setClientSecret('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');
    $client->setRedirectUri('http://localhost:8000/google-drive/callback');
    $code = request('code');
    $access_token = $client->fetchAccessTokenWithAuthCode($code);
    return $access_token; */
});

Route::get('upload', function () {
    $client = new Client();
    $access_token = 'ya29.a0ARrdaM-27Y5fv6ibiXyMqGM9Yr_nfdF43t3QCNDB72OXq-9v_K-MTfNnWzvjI_bkJYxDXTINDv37_TQ-HY9GNN-dNFZbJ9kXI46_xScesKIsKejuVWmujp4u78RFFw8BrM9Z1nx7Fm0PZKQCQhzjp0qTr7j_';

    $client->setAccessToken($access_token);
    $service = new Google\Service\Drive($client);
    $file = new Google\Service\Drive\DriveFile();

    DEFINE("TESTFILE", 'testfile-small.txt');
    if (!file_exists(TESTFILE)) {
        $fh = fopen(TESTFILE, 'w');
        fseek($fh, 1024 * 1024);
        fwrite($fh, "!", 1);
        fclose($fh);
    }

    $file->setName("Hello World!");
    $service->files->create(
        $file,
        array(
            'data' => file_get_contents(TESTFILE),
            'mimeType' => 'application/octet-stream',
            'uploadType' => 'multipart'
        )
    );
});
