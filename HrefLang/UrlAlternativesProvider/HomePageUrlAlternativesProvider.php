<?php
declare(strict_types=1);

namespace Brandung\Seo\HrefLang\UrlAlternativesProvider;

use Brandung\Seo\HrefLang\AlternativeStoreProvider;
use Brandung\Seo\HrefLang\Data\HrefLangAlternativeFactory;
use Brandung\Seo\HrefLang\Data\HrefLangAlternativeInterface;
use Brandung\Seo\HrefLang\HrefLangValueProvider;
use Magento\Store\Model\Store;

class HomePageUrlAlternativesProvider implements UrlAlternativesProviderInterface
{
    /**
     * @var AlternativeStoreProvider
     */
    private $alternativeStoreProvider;
    /**
     * @var HrefLangValueProvider
     */
    private $hrefLangValueProvider;
    /**
     * @var HrefLangAlternativeFactory
     */
    private $alternativeFactory;

    public function __construct(
        AlternativeStoreProvider $alternativeStoreProvider,
        HrefLangValueProvider $hrefLangValueProvider,
        HrefLangAlternativeFactory $alternativeFactory
    ) {
        $this->alternativeStoreProvider = $alternativeStoreProvider;
        $this->hrefLangValueProvider = $hrefLangValueProvider;
        $this->alternativeFactory = $alternativeFactory;
    }

    /**
     * @return HrefLangAlternativeInterface[]
     */
    public function getAlternatives(): array
    {
        return array_map(function (Store $store) {
            return $this->getAlternativeForStore($store);
        }, $this->alternativeStoreProvider->getAlternativeStores());
    }

    /**
     * @return HrefLangAlternativeInterface|null
     */
    public function getDefaultAlternative(): ?HrefLangAlternativeInterface
    {
        $store = $this->alternativeStoreProvider->getDefaultStore();
        return $this->getAlternativeForStore($store);
    }

    /**
     * @param Store $store
     * @return HrefLangAlternativeInterface
     */
    private function getAlternativeForStore(Store $store): HrefLangAlternativeInterface
    {
        $hrefLang = $this->hrefLangValueProvider->getValue($store);
        return $this->alternativeFactory->create($hrefLang, $store->getBaseUrl());
    }
}
