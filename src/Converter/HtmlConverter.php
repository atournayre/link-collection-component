<?php

namespace Atournayre\Component\LinkCollection\Converter;

use Atournayre\Component\LinkCollection\LinkCollection;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\WebLink\Link;

class HtmlConverter implements LinkCollectionConverterInterface
{
    public static function getLinks(LinkCollection $linkCollection): Collection
    {
        $collection = new ArrayCollection($linkCollection->toArray());

        return $collection->map(
            function (Link $link) {
                return sprintf(
                    '<a href="%s" %s>%s</a>',
                    $link->getHref(),
                    self::attributeAsString($link),
                    $link->getAttributes()['title'] ?? null,
                );
            }
        );
    }

    protected static function attributeAsString(Link $link): string
    {
        $attributes = $link->getAttributes();

        return implode(' ', array_map(
                function ($attributeKey, $attributeValue) {
                    if ($attributeKey === $attributeValue) return $attributeKey;
                    if (is_bool($attributeValue)) return $attributeKey . '="' . var_export($attributeValue, true) . '"';
                    return $attributeKey . '="' . $attributeValue . '"';
                },
                array_keys($attributes),
                $attributes
            )
        );
    }
}
