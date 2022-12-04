<?php

namespace Dasha\Laptopshop;

use Dasha\Laptopshop\Tables\NotebookOptionTable;
use Dasha\Laptopshop\Tables\OptionTable;
use Exception;

class Option
{

    /**
     * @throws Exception
     */
    public static function fillWithTestData()
    {
        $data = file_get_contents(
            $_SERVER['DOCUMENT_ROOT'] . '/local/modules/dasha.laptopshop/install/testdata/option.json'
        );
        $options = json_decode($data, true);

        foreach ($options as $option) {
            OptionTable::add($option);
        }

        $data = file_get_contents(
            $_SERVER['DOCUMENT_ROOT'] . '/local/modules/dasha.laptopshop/install/testdata/notebookoption.json'
        );
        $fields = json_decode($data, true);

        foreach ($fields as $field) {
            NotebookOptionTable::add($field);
        }
    }
}