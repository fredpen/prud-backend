<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class FileHelper
{
    public static function  storeAFile($requestFile, string $location, $key = false)
    {
        $time =  time();
        $extension = $requestFile->extension();

        $fileName = $key ? "$key$time.{$extension}" : "$time.{$extension}";
        $url =  $requestFile->storeAs($location, $fileName);

        return Storage::url($url);
    }

    public static function  removeAfile($urls)
    {
        $baseUrl = Config::get('app.url') . "/storage/";

        $urls = $urls->map(function ($item)  use ($baseUrl) {
            return $item = str_replace($baseUrl, "", $item);
        });

        return Storage::disk('public')->delete($urls->toArray());
    }
}
