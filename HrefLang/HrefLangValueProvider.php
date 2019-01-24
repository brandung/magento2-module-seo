<?php
declare(strict_types=1);

namespace Brandung\Seo\HrefLang;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\Store;

class HrefLangValueProvider
{
    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    public function __construct(ScopeConfigInterface $scopeConfig)
    {
        $this->scopeConfig = $scopeConfig;
    }

    public function getValue(Store $store, string $configScope = ScopeInterface::SCOPE_STORE): string
    {
        $localeCode = $this->scopeConfig->getValue(
            \Magento\Directory\Helper\Data::XML_PATH_DEFAULT_LOCALE,
            $configScope,
            $store->getId()
        );
        return strtolower(str_replace('_', '-', $localeCode));
    }
}
