<?php

namespace Knovators\Support\Helpers;

use Buglinjo\LaravelWebp\Facades\Webp;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Class UploadService
 * @package Knovators\Support\Helpers
 */
class UploadService
{

    /**
     * @param $file
     * @param $path
     * @param $name
     * @return mixed
     */
    public static function storeMedia($file, $path, $name, $driver) {

        if (is_string($file)) {
            $file = Storage::disk($driver)->write("$path/$name", $file);
        } else {
            if (config('media.convert_in_webp')) {
                $names = explode('.', $name);
                $fileName = array_shift($names).'.webp';
                $webp = Webp::make($file);
                $webp->save(public_path($path . DIRECTORY_SEPARATOR .$fileName));
            }
            $file->storeAs($path, $name, $driver);
        }

        return $file;
    }

    /**
     * @param $userId
     * @param $folder
     * @return string
     */
    public static function getDBFilePath($userId, $folder) {
        return "{$userId}/{$folder}";
    }


    /**
     * @param UploadedFile $file
     * @return string
     */
    public static function getFileName(UploadedFile $file) {

        $name = $file->getClientOriginalName();

        return Str::slug(Str::substr($name, 0, mb_strrpos($name,
                '.'))) . '_' . Carbon::now()->timestamp . '.' . $file->getClientOriginalExtension();
    }

    /**
     * @param $mime
     * @return bool|string
     */
    public static function getFileLocation($mime) {
        if (Str::contains($mime, 'image')) {
            return 'image';
        } elseif (Str::contains($mime, 'video')) {
            return 'video';
        } elseif (Str::contains($mime, 'audio')) {
            return 'audio';
        } elseif (Str::contains($mime, 'word')) {
            return 'word';
        } elseif (Str::contains($mime, 'pdf')) {
            return 'pdf';
        } else {
            return mb_substr($mime, 0, mb_strpos($mime, '/') - 1);
        }

    }


}
