<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

function file_upload($file, $path, $base_64 = false)
{
    if ($base_64) {
        $image_64 = $file; //your base64 encoded data
        $path = $path . '/';

        $extension = explode(
            '/',
            explode(':', substr($image_64, 0, strpos($image_64, ';')))[1]
        )[1]; // .jpg .png .pdf

        $replace = substr($image_64, 0, strpos($image_64, ',') + 1);

        // find substring for replace here eg: data:image/png;base64,

        $image = str_replace($replace, '', $image_64);

        $image = str_replace(' ', '+', $image);

        $imageName = Str::random(40) . '.' . $extension;

        Storage::disk('public')->put($path . $imageName, base64_decode($image));

        $url = '/storage/' . $path . $imageName;
    } else {
        $imageName =
            substr((Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . "-" .  Carbon::now()->timestamp), 0, 100) . '.' .  $file->getClientOriginalExtension();
        $url = '/storage/' . Storage::disk('public')->putFileAs($path, $file, $imageName);
    }

    return $url;
}