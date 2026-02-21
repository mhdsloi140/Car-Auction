<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Support\Facades\Response;

class MediaController extends Controller
{
       public function download($mediaId)
    {
        $media = Media::findOrFail($mediaId);

        return Response::download($media->getPath(), $media->file_name);
    }
}
