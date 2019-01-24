<?php
declare(strict_types=1);

namespace Brandung\Seo\HrefLang\Data;

class HrefLangAlternative implements HrefLangAlternativeInterface
{
    /**
     * @var string
     */
    private $hrefLang;
    /**
     * @var string
     */
    private $href;

    public function __construct(string $hrefLang, string $href)
    {
        $this->hrefLang = $hrefLang;
        $this->href = $href;
    }

    public function getHrefLang(): string
    {
        return $this->hrefLang;
    }

    public function getHref(): string
    {
        return $this->href;
    }
}
