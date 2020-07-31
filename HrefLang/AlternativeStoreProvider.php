<?php
declare(strict_types=1);

namespace Brandung\Seo\HrefLang;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Api\Data\StoreInterface;
use Magento\Store\Model\Store;
use Magento\Store\Model\StoreManagerInterface;

class AlternativeStoreProvider
{
    const XML_PATH_HREFLANG_EXCLUDE_STORES = 'general/locale/hreflang_exclude_stores';
    const XML_PATH_HREFLANG_DEFAULT_STORE = 'general/locale/hreflang_default_store';

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;
    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    public function __construct(
        StoreManagerInterface $storeManager,
        ScopeConfigInterface $scopeConfig
    ) {
        $this->storeManager = $storeManager;
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * @return Store[]
     */
    public function getAlternativeStores(): array
    {
        return array_filter($this->storeManager->getStores(), function (Store $store) {
            return $store->getId() !== $this->storeManager->getStore()->getId()
                && $store->isActive()
                && !in_array(
                    $store->getCode(),
                    explode(
                        ',',
                        (string) $this->scopeConfig->getValue(self::XML_PATH_HREFLANG_EXCLUDE_STORES, 'stores')
                    )
                );
        });
    }

    /**
     * @return Store|StoreInterface
     */
    public function getDefaultStore(): Store
    {
        if ($defaultStoreCode = $this->scopeConfig->getValue(self::XML_PATH_HREFLANG_DEFAULT_STORE)) {
            return $this->storeManager->getStore($defaultStoreCode);
        }
        return $this->storeManager->getDefaultStoreView();
    }
}
