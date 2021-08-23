<?php

namespace App\Traits;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;

trait UserTraits
{
    public function storeMyFile($requestFile, string $location, int $userId)
    {
        $baseUrl = Config::get('app.url');
        $extension = $requestFile->extension();
        $randomString = "937840jasiu8ygbcj7383737d{$userId}";

        $fileName = "$randomString.{$extension}";
        $url =  $requestFile->storeAs($location, $fileName);

        return Storage::url($url);
    }
}
