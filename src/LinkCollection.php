<?php

namespace Atournayre\Component\LinkCollection;

use Atournayre\Component\LinkCollection\Exception\LinkCollectionException;
use Closure;
use Doctrine\Common\Collections\ArrayCollection;
use Exception;
use Symfony\Component\WebLink\Link;

class LinkCollection extends ArrayCollection
{
    /**
     * @throws Exception
     */
    public function __construct(array $elements = [])
    {
        parent::__construct($elements);

        !$this->allElementsAreLinks() && throw LinkCollectionException::createForAllElements();
    }

    private function allElementsAreLinks(): bool
    {
        return $this->forAll(fn ($index, $element) => $element instanceof Link);
    }

    /**
     * @throws Exception
     */
    public function add($element, Closure $func = null): bool
    {
        if ($this->closureIsCallable($func)) return false;

        $this->throwExceptionIfElementIsNotInstanceOfLink($element);
        return parent::add($element);
    }

    /**
     * @param Closure|null $func
     *
     * @return bool
     */
    private function closureIsCallable(Closure $func = null): bool
    {
        return !is_null($func) && !$func();
    }

    /**
     * @throws Exception
     */
    private function elementIsInstanceOfLink($element): bool
    {
        return $element instanceof Link;
    }

    /**
     * @throws Exception
     */
    private function throwExceptionIfElementIsNotInstanceOfLink($element)
    {
        !$this->elementIsInstanceOfLink($element) && throw LinkCollectionException::createForElement();
    }

    /**
     * @throws Exception
     */
    public function set($key, $value, Closure $func = null): void
    {
        if ($this->closureIsCallable($func)) return;

        $this->throwExceptionIfElementIsNotInstanceOfLink($value);
        parent::set($key, $value);
    }
}
