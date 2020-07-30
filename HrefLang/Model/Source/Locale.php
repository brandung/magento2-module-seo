<?php

declare(strict_types=1);

namespace Brandung\Seo\HrefLang\Model\Source;

class Locale extends \Magento\Config\Model\Config\Source\Locale
{
    /**
     * @return array
     */
    public function toOptionArray()
    {
        $options = [['value' => '', 'label' => '']];
        foreach (parent::toOptionArray() as $option) {
            $options[] = [
                'value' => $option['value'],
                'label' => strtolower(str_replace('_', '-', $option['value']))
            ];
        }
        usort(
            $options,
            function ($a, $b) {
                return $a['label'] <=> $b['label'];
            }
         );

        return $options;
    }
}
