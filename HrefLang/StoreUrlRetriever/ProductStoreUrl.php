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

    public function __construct(
        ProductRepositoryInterface $productRepository,
        ProductUrlPathGenerator $urlPathGenerator
    ) {
        $this->productRepository = $productRepository;
        $this->urlPathGenerator = $urlPathGenerator;
    }

    /**
     * @param int $entityId
     * @param Store $store
     * @return string
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getUrl(int $entityId, Store $store)
    {
        /** @var Product $product */
        $product = $this->productRepository->getById($entityId, false, $store->getId());
        $path = $this->urlPathGenerator->getUrlPathWithSuffix($product, $store->getId());
        return $store->getBaseUrl() . $path;
    }
}
