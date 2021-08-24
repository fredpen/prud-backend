<?php

namespace App\Http\Controllers;

use App\Helpers\FileHelper;
use App\Helpers\ResponseHelper;
use App\Models\Mba;
use Illuminate\Http\Request;

class MbaPhotoController extends Controller
{
    public function attachMedia(Request $request)
    {
        $this->authorize('create', $request->user());
        $this->validateRequest($request);

        $mba = Mba::where('id', $request->id)->first();
        if (!$mba) {
            return ResponseHelper::notFound("Invalid Mba Id");
        }

        $urls = [];
        $location = str_replace(" ", "", "mbaAvatars/{$mba->name}");
        foreach ($request->file('photos') as $key => $file) {
            $url =  FileHelper::storeAFile($file,  $location, $key);
            $urls[] = ['url' => $url];
        }

        $saveFile = $mba->photos()->createMany($urls);
        if (!$saveFile) {
            return ResponseHelper::serverError();
        }

        return ResponseHelper::sendSuccess("mba Updated");
    }

    public function detachMedia(Request $request)
    {
        $this->authorize('create', $request->user());
        $request->validate(['media_ids' => ['required', 'array'], "id" => 'exists:mba_photos,id']);

        $mba = Mba::where('id', $request->id)->first();
        if (!$mba) {
            return ResponseHelper::notFound("Invalid Mba Id");
        }

        $photos = $mba->photos()->whereIn('id', $request->media_ids);
        if (!$photos->count()) {
            return ResponseHelper::serverError("Invalid media IDs");
        }

        $photoUrls =  $photos->pluck('url');
        FileHelper::removeAfile($photoUrls);

        if (!$photos->delete()) {
            return ResponseHelper::serverError();
        }

        return ResponseHelper::sendSuccess("mba Updated");
    }

    private function validateRequest(Request $request)
    {
        $request->validate([
            'photos' => ['required'],
            'photos.*' => ['required', 'file', 'mimes:jpeg,jpg,png', 'max:2048'],
        ]);
    }
}
