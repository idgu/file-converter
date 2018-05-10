<?php

namespace App\Misc;

use Upload\Storage\FileSystem;
use Upload\Validation\Mimetype;
use Upload\Validation\Size;

class FileSaver
{
    public $storage;

    /**
     * @var File
     */
    public $file;
    public $filePath;
    public $errors = array();

    /**
     * Validate and save file to given directory.
     *
     * @param $input string     File input name.
     * @param $name string      File name, must be unique.
     * @param $directory string Path directory, where file should be save.
     * @param $mimes array      Mimes.
     * @param string $size      Max size of file
     * @return bool             If validate came successfully.
     */
    public function save($input, $name,$directory, $mimes, $size = '5M')
    {
        $storage = new FileSystem($directory);

        $file = new File($input, $storage);
        $file->setName($name);
        $file->setFilePath(__DIR__ . '/../../var/temp/'  .$file->getNameWithExtension());
        $file->addValidations(array(
            new Mimetype($mimes),
            new Size($size)
        ));

        try {
            $file->upload();

            $this->file = $file;
            $this->storage = $storage;
        } catch (\Exception $e) {
            $this->errors = $file->getErrors();
        }

        return $this->hasErrors();
    }

    /**
     * Get file.
     *
     * @return File
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Get errors
     *
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * Checks whether the validation was successful.
     *
     * @return bool
     */
    public function hasErrors()
    {
        return empty($this->errors) === false;
    }

    /**
     * Check if isset file from form.
     *
     * @param $name
     * @return bool
     */
    public static function issetFileToSave($name)
    {
        return isset($_FILES[$name]['name']) && empty($_FILES[$name]['name']) === false;
    }

    /**
     * Display errors.
     */
    public function displayErrors()
    {
        echo '<ul>';
        foreach ($this->getErrors() as $error) {
            echo '<li>'. $error .'</li>';
        }
        echo '<ul>';
    }
}