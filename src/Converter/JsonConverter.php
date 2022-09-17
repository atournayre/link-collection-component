<?php

namespace Atournayre\Component\LinkCollection\Converter;

use Atournayre\Component\LinkCollection\LinkCollection;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\WebLink\Link;

class JsonConverter implements LinkCollectionConverterInterface
{
    public static function getLinks(LinkCollection $linkCollection): Collection
    {
        $collection = new ArrayCollection($linkCollection->toArray());

        $serializer = new Serializer([new ObjectNormalizer()], [new JsonEncoder()]);

        return $collection->map(fn(Link $link) => $serializer->serialize($link, 'json'));
    }
}
