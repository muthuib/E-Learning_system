<?php

namespace app\helpers;

use yii\base\BaseObject;
use yii\web\UploadedFile;

class FileHelper extends BaseObject
{
// Define the default upload path
const UPLOAD_PATH = '@webroot/uploads/courses';

/**
* Save the uploaded file to the server.
*
* @param UploadedFile $file The uploaded file
* @param string $path The directory to save the file
* @return string|false The saved file path or false if failed
*/
public static function saveFile(UploadedFile $file, $path = self::UPLOAD_PATH)
{
// Normalize the path
$path = \Yii::getAlias($path);

// Create the directory if it doesn't exist
if (!is_dir($path)) {
mkdir($path, 0775, true);
}

// Generate a unique file name
$fileName = uniqid() . '.' . $file->extension;

// Save the file to the desired directory
if ($file->saveAs($path . '/' . $fileName)) {
return $fileName; // Return the saved file name
}

return false; // Return false if save failed
}

/**
* Validate the uploaded file type.
*
* @param UploadedFile $file The uploaded file
* @param array $validTypes Array of valid MIME types (e.g., ['image/png', 'image/jpeg'])
* @return bool Whether the file type is valid
*/
public static function validateFileType(UploadedFile $file, array $validTypes)
{
return in_array($file->type, $validTypes);
}

/**
* Get the file extension of an uploaded file.
*
* @param UploadedFile $file The uploaded file
* @return string|null The file extension, or null if invalid
*/
public static function getFileExtension(UploadedFile $file)
{
return $file->extension;
}
}