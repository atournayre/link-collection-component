<?php

namespace Atournayre\Component\LinkCollection\Converter;

use Atournayre\Component\LinkCollection\LinkCollection;
use Doctrine\Common\Collections\Collection;

interface LinkCollectionConverterInterface
{
    public static function getLinks(LinkCollection $linkCollection): Collection;
}
