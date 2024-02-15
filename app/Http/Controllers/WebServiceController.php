<?php

namespace App\Http\Controllers;

use App\Http\Resources\TaskResource;
use App\Models\Service;
use App\Models\Task;
use App\Services\GoogleDrive;
use App\Services\Zipper;
use Google\Client;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class WebServiceController extends Controller
{
    public const DRIVE_SCOPES = [
        'https://www.googleapis.com/auth/drive',
        'https://www.googleapis.com/auth/drive.file',
    ];

    public function connect($service_name, Client $client)
    {
        if ($service_name == 'google-drive') {
            /* $config = config('services.google');
            $client = new Client();
            $client->setClientId($config['id']);
            $client->setClientSecret($config['secret']);
            $client->setRedirectUri($config['callback_url']); */
            $client->setScopes(self::DRIVE_SCOPES);
            $url = $client->createAuthUrl();
            return ['url' => $url];
        }
    }

    public function callback(Request $request, Client $client)
    {
        //$client = new Client();
        $access_token = $client->fetchAccessTokenWithAuthCode($request->code);

        $service = Service::create(['user_id' => auth()->id(), 'name' => 'google-drive', 'token' => $access_token]);
        return $service;
    }

    public function store(Service $service_name, GoogleDrive $googleDrive)
    {
        //We need to fetch 7 days task
        $tasks = Task::Where('created_at', '>=', now()->subDays(7))->get();

        //Create file with this data
        $jsonFileName = 'task_dump.json';
        Storage::put("/public/temp/$jsonFileName", TaskResource::collection($tasks)->toJson());
        $zipFileName = Zipper::createZipOf($jsonFileName);
        //Send this zip to drive
        $access_token = $service_name->token['access_token'];
        $googleDrive->uploadFile($zipFileName, $access_token);
        //Storage::deleteDirectory('public/temp');
        return response('Uploaded', Response::HTTP_CREATED);
    }
}
