<?php
declare(strict_types=1);

namespace Brandung\Seo\HrefLang\StoreUrlRetriever;

use Magento\Store\Model\Store;

interface StoreUrlInterface
{
    public function getUrl(int $entityId, Store $store): string;
}
