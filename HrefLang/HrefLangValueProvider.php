<?php
declare(strict_types=1);

namespace Brandung\Seo\HrefLang;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\Store;

class HrefLangValueProvider
{
    const XML_PATH_LOCALE_FOR_HREFLANG = 'general/locale/code_for_hreflang';

    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;
    /**
     * @var string
     */
    private $localeConfigScope;

    public function __construct(
        ScopeConfigInterface $scopeConfig,
        string $localeConfigScope
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->localeConfigScope = $localeConfigScope;
    }

    public function getValue(Store $store): string
    {
        $localeCode = $this->scopeConfig->getValue(
            self::XML_PATH_LOCALE_FOR_HREFLANG,
            $this->localeConfigScope,
            $this->getScopeCode($store)
        );
        if (!$localeCode) {
            $localeCode = $this->scopeConfig->getValue(
                \Magento\Directory\Helper\Data::XML_PATH_DEFAULT_LOCALE,
                $this->localeConfigScope,
                $this->getScopeCode($store)
            );
        }
        return strtolower(str_replace('_', '-', $localeCode));
    }

    private function getScopeCode(Store $store): string
    {
        switch ($this->localeConfigScope) {
            case ScopeInterface::SCOPE_WEBSITE:
                return (string)$store->getWebsiteId();
            default:
                return (string)$store->getId();
        }
    }
}
