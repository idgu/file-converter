<?php

namespace App\Misc;

use Upload\Storage\Base;

class File extends \Upload\File
{
    private $filePath;
    private $fileData;

    public function __construct($key, Base $storage)
    {
        parent::__construct($key, $storage);
        $this->setFilePath(__DIR__ . '/../../var/temp/'  .$this->getNameWithExtension());
    }

    /**
     * Save data from file to $this->fileData as array assoc.
     *
     * @return bool
     */
    public function prepareData()
    {
        switch ($this->getExtension()) {
            case "xml":
                return $this->convertXMLToAssoc();
                break;
            case "json":
                return $this->convertJSONToAssoc();
                break;
        }
    }

    private function convertXMLToAssoc()
    {
        libxml_use_internal_errors(true);
        $xml = simplexml_load_file($this->getFilePath());
        if ($xml) {
            $data['root'] = $xml->getName();
            $data['params'] = $xml;
            $this->setFileData($data);
                return true;
        } else
            return false;
    }

    private function convertJSONToAssoc()
    {
        $file = file_get_contents($this->getFilePath());
        $arr = json_decode($file, true);
        if (!empty($arr)) {
            $data['params'] = $arr;
            $this->setFileData($data);
            return true;
        } else
            return false;
    }

    /**
     * Set file path.
     *
     * @param $path
     */
    public function setFilePath($path)
    {
        $this->filePath = $path;
    }

    /**
     * Get file path.
     *
     * @return mixed
     */
    public function getFilePath()
    {
        return $this->filePath;
    }

    /**
     * Set file data.
     * @param $data
     */
    public function setFileData($data)
    {
        $this->fileData = $data;
    }

    /**
     * Get file data.
     *
     * @return mixed
     */
    public function getFileData()
    {
        return $this->fileData;
    }

}