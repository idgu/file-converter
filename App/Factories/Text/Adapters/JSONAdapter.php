<?php

namespace App\Factories\Text\Adapters;

use App\Factories\Text\TextAdapterInterface;

class JSONAdapter implements TextAdapterInterface
{

    public function output($data)
    {
        return $this->convert($data);
    }

    /**
     * Converts assoc array to JSON string.
     *
     * @param $data
     * @return string
     */
    function convert($data) {
        return json_encode($data['params']);
    }

    public static function headers()
    {
        header('Content-Type: application/json');
    }
}