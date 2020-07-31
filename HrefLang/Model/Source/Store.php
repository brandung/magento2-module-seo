<?php

declare(strict_types=1);

namespace Brandung\Seo\HrefLang\Model\Source;

use Magento\Store\Model\StoreManagerInterface;

class Store implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    public function __construct(
        StoreManagerInterface $storeManager
    ) {
        $this->storeManager = $storeManager;
    }

    /**
     * @return array
     */
    public function toOptionArray()
    {
        $options = [['value' => '', 'label' => __('--- None ---')]];
        foreach ($this->storeManager->getStores() as $store) {
            $options[] = [
                'value' => $store->getCode(),
                'label' => sprintf('%s [%s]', $store->getName(), $store->getCode()),
            ];
        }
        return $options;
    }
}
