<?php
declare(strict_types=1);

namespace Brandung\Seo\HrefLang\UrlAlternativesProvider;

use Brandung\Seo\HrefLang\AlternativeStoreProvider;
use Brandung\Seo\HrefLang\Data\HrefLangAlternativeFactory;
use Brandung\Seo\HrefLang\Data\HrefLangAlternativeInterface;
use Brandung\Seo\HrefLang\HrefLangValueProvider;
use Brandung\Seo\HrefLang\StoreUrlRetriever\StoreUrlInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Store\Model\Store;

abstract class AbstractUrlAlternativesProvider implements UrlAlternativesProviderInterface
{
    /**
     * @var AlternativeStoreProvider
     */
    private $alternativeStoreProvider;
    /**
     * @var StoreUrlInterface
     */
    private $storeUrl;
    /**
     * @var HrefLangAlternativeFactory
     */
    private $alternativeFactory;
    /**
     * @var RequestInterface
     */
    private $request;
    /**
     * @var HrefLangValueProvider
     */
    private $hrefLangValueProvider;

    public function __construct(
        AlternativeStoreProvider $alternativeStoreProvider,
        HrefLangAlternativeFactory $alternativeFactory,
        StoreUrlInterface $storeUrl,
        RequestInterface $request,
        HrefLangValueProvider $hrefLangValueProvider
    ) {
        $this->alternativeStoreProvider = $alternativeStoreProvider;
        $this->storeUrl = $storeUrl;
        $this->alternativeFactory = $alternativeFactory;
        $this->request = $request;
        $this->hrefLangValueProvider = $hrefLangValueProvider;
    }

    abstract public function getRequestIdFieldName(): string;

    /**
     * @return HrefLangAlternativeInterface[]
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getAlternatives(): array
    {
        return array_map(function (Store $store) {
            return $this->getAlternativeForStore($store);
        }, $this->alternativeStoreProvider->getAlternativeStores());
    }

    /**
     * @return HrefLangAlternativeInterface|null
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getDefaultAlternative(): ?HrefLangAlternativeInterface
    {
        $store = $this->alternativeStoreProvider->getDefaultStore();
        return $this->getAlternativeForStore($store);
    }

    /**
     * @return int
     */
    private function getEntityId(): int
    {
        return (int)$this->request->getParam($this->getRequestIdFieldName());
    }

    /**
     * @param Store $store
     * @return HrefLangAlternativeInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    private function getAlternativeForStore(Store $store): HrefLangAlternativeInterface
    {
        $hrefLang = $this->hrefLangValueProvider->getValue($store);
        $href = $this->storeUrl->getUrl($this->getEntityId(), $store);
        return $this->alternativeFactory->create($hrefLang, $href);
    }
}
