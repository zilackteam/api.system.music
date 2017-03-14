<?php

const DS = DIRECTORY_SEPARATOR;

if (!function_exists('upload_path')) {
    /**
     * Get the path to the base of the install.
     *
     * @param  string $path
     * @return string
     */
    function upload_path($path = '') {
        return app()->basePath() .
            DS . 'resources' .
            DS . 'uploads' .
            ($path ? DS . $path : $path);
    }
}

function album_path($singerId) {
    return upload_path($singerId . DS . 'album');
}
function song_path($singerId, $songId) {
    return upload_path($singerId . DS . 'song' . DS . $songId);
}
function avatar_path($userId) {
    return upload_path($userId . DS . 'avatar');
}
function news_path($userId) {
    return upload_path($userId . DS . 'news');
}
function photo_path($userId) {
    return upload_path($userId . DS . 'photo');
}
function video_path($userId) {
    return upload_path($userId . DS . 'video');
}
function post_path($userId) {
    return upload_path($userId . DS . 'post');
}
function website_path($userId) {
    return upload_path($userId . DS . 'website');
}


/**
 * Upload photo
 *
 * @param $request - POST request
 * @param $field - field name in database
 * @param $dir - location to save file
 * @param $name - new name of file
 * @return bool
 */
function uploadImage($request, $field, $dir, $name) {

    if ($request->hasFile($field) && $request->file($field)->isValid()) {
        $image = $request->file($field);
        $imageType = $image->getClientOriginalExtension();

        $fileName = $name . '.' . $imageType;

        if (! \File::isDirectory($dir)) {
            \File::makeDirectory($dir, 0775, true);
        }

        $imgSaved = Image::make($image->getRealPath())->save($dir . DS . $fileName);
        $thumbSaved = Image::make($image->getRealPath())->fit(200, 200)->save($dir . DS . 'thumb_' .$fileName);

        if ($imgSaved && $thumbSaved)
            return $fileName;
    }

    return false;
}

/**
 * Upload file media
 *
 * @param $request - POST request
 * @param $field - field name in database
 * @param $dir - location to save file
 * @param $name - new name of file
 * @return bool
 */
function uploadMedia($request, $field, $dir, $name) {
    if ($request->hasFile($field) && $request->file($field)->isValid()) {
        $file = $request->file($field);
        $fileType = $file->getClientOriginalExtension();

        $fileName = $name . '.' . $fileType;

        if (! \File::isDirectory($dir)) {
            \File::makeDirectory($dir, 0775, true);
        }

        $move = $request->file($field)->move($dir, $fileName);

        if ($move)
            return $fileName;
    }

    return false;
}

/**
 * Upload photo
 *
 * @param $request - POST request
 * @param $field - field name in database
 * @param $dir - location to save file
 * @param $name - new name of file
 * @return bool
 */
function uploadPhoto($request, $field, $dir, $name) {

    if ($request->hasFile($field) && $request->file($field)->isValid()) {
        $image = $request->file($field);
        $imageType = $image->getClientOriginalExtension();

        $fileName = $name . '.' . $imageType;

        if (! \File::isDirectory($dir)) {
            \File::makeDirectory($dir, 0775, true);
        }

        $imgSaved = Image::make($image->getRealPath())->save($dir . DS . $fileName);
//         $thumbSaved = Image::make($image->getRealPath())
//             ->resize(200, null, function ($constraint) {
//                 $constraint->aspectRatio();
//             })
//             ->save($dir . DS . 'thumb_' .$fileName);

        if ($imgSaved)
            return $fileName;
    }

    return false;
}

function saveThumb($data, $dir, $name) {
    $fileName = $name . '.png';
    
    $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $data));
    $imgSaved = file_put_contents($dir . DS . $fileName, $data);
    
    if ($imgSaved)
        return $fileName;
    
    return false;
}


function remove($filePath) {

}