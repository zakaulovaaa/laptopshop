<?php

namespace Dasha\Laptopshop;

class UrlHelper
{
    private string $SEF_FOLDER;
    private array $SEF_URL_TEMPLATES = [
        'brands' => '',
        'models' => '#BRAND_CODE#/',
        'detail' => 'detail/#NOTEBOOK_CODE#/',
        'notebooks' => '#BRAND_CODE#/#MODEL_CODE#/'
    ];

    public function __construct($sefFolder)
    {
        $this->SEF_FOLDER = $sefFolder ?? '';
    }

    public function getUrlBrand($code)
    {
        if (empty($this->SEF_FOLDER) || empty($this->SEF_URL_TEMPLATES['models'])) {
            return false;
        }
        return $this->SEF_FOLDER . str_replace('#BRAND_CODE#', $code, $this->SEF_URL_TEMPLATES['models']);
    }

    public function getUrlModel($code, $codeBrand = '')
    {
        if (empty($this->SEF_FOLDER) || empty($this->SEF_URL_TEMPLATES['notebooks'])) {
            return false;
        }
        return $this->SEF_FOLDER . str_replace(
                ['#MODEL_CODE#', '#BRAND_CODE#'],
                [$code, $codeBrand],
                $this->SEF_URL_TEMPLATES['notebooks']
            );
    }

    public function getUrlNotebook($code)
    {
        if (empty($this->SEF_FOLDER) || empty($this->SEF_URL_TEMPLATES['notebooks'])) {
            return false;
        }

        return $this->SEF_FOLDER . str_replace('#NOTEBOOK_CODE#', $code, $this->SEF_URL_TEMPLATES['detail']);
    }
}