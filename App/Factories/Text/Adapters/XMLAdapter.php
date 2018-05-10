<?php

namespace App\Factories\Text\Adapters;

use App\Factories\Text\TextAdapterInterface;

class XMLAdapter implements TextAdapterInterface
{

    public function output($data)
    {
        $root = !empty($data['root']) ? '<' . $data['root'] . '></' . $data['root'] . '>' : '<root></root>';
        $xml_user_info = new \SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?>'. $root);
        $this->convert($data['params'],$xml_user_info);

        $xml = new \DomDocument();
        $xml->recover=true;

        libxml_use_internal_errors(true);
        $xml->loadXML($xml_user_info->asXML());

        return  $xml->saveXML();
    }

    /**
     * Converts assoc array to XML.
     *
     * @param $array
     * @param $xml_user_info
     */
    function convert($array, &$xml_user_info) {
        foreach($array as $key => $value) {
            if(is_array($value)) {
                if(!is_numeric($key)){
                    $subnode = $xml_user_info->addChild("$key");
                    $this->convert($value, $subnode);
                }else{
                    $subnode = $xml_user_info->addChild("item$key");
                    $this->convert($value, $subnode);
                }
            }else {
                $xml_user_info->addChild("$key","$value");
            }
        }
    }

    public static function headers()
    {
        header('Content-Type: text/xml');
        header('Content-Type: application/xml');
    }

}