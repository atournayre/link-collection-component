<?php

namespace Atournayre\Component\LinkCollection\Exception;

use Symfony\Component\WebLink\Link;

class LinkCollectionException extends \Exception
{
    public static function createForAllElements(): self
    {
        return new self(sprintf('At least, one of the elements is not an instance of %s.', Link::class));
    }

    public static function createForElement(): self
    {
        return new self(sprintf('Instance of %s expected.', Link::class));
    }
}
