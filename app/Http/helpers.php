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

function album_path($contentId) {
    return upload_path($contentId . DS . 'album');
}
function song_path($contentId, $songId) {
    return upload_path($contentId . DS . 'song' . DS . $songId);
}
function beat_path($contentId, $beatId) {
    return upload_path($contentId . DS . 'beat' . DS . $beatId);
}
function avatar_path($userId) {
    return upload_path('users'. DS . $userId . DS . 'avatar');
}
function news_path($contentId) {
    return upload_path($contentId . DS . 'news');
}
function photo_path($contentId) {
    return upload_path($contentId . DS . 'photo');
}
function video_path($contentId) {
    return upload_path($contentId . DS . 'video');
}
function post_path($contentId) {
    return upload_path($contentId . DS . 'post');
}
function website_path($contentId) {
    return upload_path($contentId . DS . 'website');
}
function application_path($contentId) {
    return upload_path($contentId . DS . 'application');
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

/**
 * Strip vietnamese
 *
 * @param $str - string
 * @return string
 */

function stripVietnamese($str) {
    $str = preg_replace("/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/", 'a', $str);
    $str = preg_replace("/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/", 'e', $str);
    $str = preg_replace("/(ì|í|ị|ỉ|ĩ)/", 'i', $str);
    $str = preg_replace("/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/", 'o', $str);
    $str = preg_replace("/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/", 'u', $str);
    $str = preg_replace("/(ỳ|ý|ỵ|ỷ|ỹ)/", 'y', $str);
    $str = preg_replace("/(đ)/", 'd', $str);

    $str = preg_replace("/(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)/", 'A', $str);
    $str = preg_replace("/(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/", 'E', $str);
    $str = preg_replace("/(Ì|Í|Ị|Ỉ|Ĩ)/", 'I', $str);
    $str = preg_replace("/(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)/", 'O', $str);
    $str = preg_replace("/(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/", 'U', $str);
    $str = preg_replace("/(Ỳ|Ý|Ỵ|Ỷ|Ỹ)/", 'Y', $str);
    $str = preg_replace("/(Đ)/", 'D', $str);

    return $str;
}


function send_notification ($key, $tokens, $message)
{
    $url = 'https://fcm.googleapis.com/fcm/send';
    $fields = array(
        'registration_ids' => $tokens,
        "notification" => $message,
        "time_to_live" => 3600,
        "priority" => 10,
    );

    $headers = array(
        'Authorization:key = ' . $key,
        'Content-Type: application/json'
    );

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

    $result = curl_exec($ch);

    if ($result === FALSE) {
        die('Curl failed: ' . curl_error($ch));
    }

    curl_close($ch);

    return $result;
}