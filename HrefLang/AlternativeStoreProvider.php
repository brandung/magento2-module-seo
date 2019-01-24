<?php
declare(strict_types=1);

namespace Brandung\Seo\HrefLang;

use Magento\Store\Model\Store;
use Magento\Store\Model\StoreManagerInterface;

class AlternativeStoreProvider
{
    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    public function __construct(StoreManagerInterface $storeManager)
    {
        $this->storeManager = $storeManager;
    }

    /**
     * @return Store[]
     */
    public function getAlternativeStores(): array
    {
        return array_filter($this->storeManager->getStores(), function (Store $store) {
            return $store->getId() !== $this->storeManager->getStore()->getId();
        });
    }

    public function getDefaultStore(): Store
    {
        return $this->storeManager->getDefaultStoreView();
    }
}
