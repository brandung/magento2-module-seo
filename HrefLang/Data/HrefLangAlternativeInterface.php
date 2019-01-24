<?php
declare(strict_types=1);

namespace Brandung\Seo\HrefLang\Data;

interface HrefLangAlternativeInterface
{
    public function __construct(string $hrefLang, string $href);
    public function getHrefLang(): string;
    public function getHref(): string;
}
