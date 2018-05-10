<?php

namespace App\Factories\Text;

use App\Factories\Text\Adapters\JSONAdapter;
use App\Factories\Text\Adapters\TXTAdapter;
use App\Factories\Text\Adapters\XMLAdapter;

class TextFactory implements TextInterface
{
    /**
     * Returns instance of chosen class or false.
     *
     * @param $adapter
     * @return JSONAdapter|TXTAdapter|XMLAdapter|bool
     */
    public function make($adapter)
    {
        if (TextEnum::isValidValue($adapter) === false)
            return false;

        switch ($adapter) {
            case TextEnum::JSON:
                return new JSONAdapter();
            case TextEnum::XML:
                return new XMLAdapter();
        }
    }
}