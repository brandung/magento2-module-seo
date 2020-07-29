<?php
declare(strict_types=1);

namespace Brandung\Seo\HrefLang\StoreUrlRetriever;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Model\Product;
use Magento\CatalogUrlRewrite\Model\ProductUrlPathGenerator;
use Magento\Store\Model\Store;

class ProductStoreUrl implements StoreUrlInterface
{
    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;
    /**
     * @var ProductUrlPathGenerator
     */
    private $urlPathGenerator;
    /**
     * @var Product\Visibility
     */
    private $visibility;

    public function __construct(
        ProductRepositoryInterface $productRepository,
        ProductUrlPathGenerator $urlPathGenerator,
        Product\Visibility $visibility
    ) {
        $this->productRepository = $productRepository;
        $this->urlPathGenerator = $urlPathGenerator;
        $this->visibility = $visibility;
    }

    /**
     * @param int $entityId
     * @param Store $store
     * @return string
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getUrl(int $entityId, Store $store): string
    {
        /** @var Product $product */
        $product = $this->productRepository->getById($entityId, false, $store->getId());
        if (!in_array($store->getWebsiteId(), $product->getWebsiteIds())) {
            throw new \Magento\Framework\Exception\NoSuchEntityException(__('Product is not assigned to website.'));
        }
        if ($product->getStatus() != Product\Attribute\Source\Status::STATUS_ENABLED) {
            throw new \Magento\Framework\Exception\NoSuchEntityException(__('Product is disabled.'));
        }
        if (!in_array($product->getVisibility(), $this->visibility->getVisibleInCatalogIds())) {
            throw new \Magento\Framework\Exception\NoSuchEntityException(__('Product is not visible.'));
        }
        $path = $this->urlPathGenerator->getUrlPathWithSuffix($product, $store->getId());
        return $store->getBaseUrl() . $path;
    }
}
