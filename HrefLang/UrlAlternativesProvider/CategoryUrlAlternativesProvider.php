<?php
declare(strict_types=1);

namespace Brandung\Seo\HrefLang\UrlAlternativesProvider;

class CategoryUrlAlternativesProvider extends AbstractUrlAlternativesProvider
{
    public function getRequestIdFieldName(): string
    {
        return 'id';
    }
}
