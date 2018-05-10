<?php

namespace App\Factories\Text;


interface TextAdapterInterface
{
    /**
     * Returns converted data.
     *
     * @param $data array
     * @return mixed
     */
    public function output($data);

    /**
     * Sets headers for adapter type.
     *
     * @return mixed
     */
    public static function headers();
}