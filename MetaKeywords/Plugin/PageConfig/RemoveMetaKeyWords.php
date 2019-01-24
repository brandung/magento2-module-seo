<?php
declare(strict_types=1);

namespace Brandung\Seo\MetaKeywords\Plugin\PageConfig;

class RemoveMetaKeyWords
{
    /**
     * @param \Magento\Framework\View\Page\Config $subject
     * @param string $return
     * @return string
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function afterGetKeywords($subject, $return)
    {
        return (string)null;
    }
}
