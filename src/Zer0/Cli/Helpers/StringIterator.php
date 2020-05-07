<?php

namespace Zer0\Cli\Helpers;

/**
 * Class StringIterator
 *
 * @package Zer0\Cli\Helpers
 */
class StringIterator implements \Iterator
{
    /**
     * @var string
     */
    private $string;

    /**
     * @var int
     */
    private $current = 0;

    /**
     * StringIterator constructor.
     *
     * @param string $string
     */
    public function __construct (string $string)
    {
        $this->string = $string;
    }

    /**
     * @return string|null
     */
    public function current (): ?string
    {
        return $this->string[$this->current] ?? null;
    }

    /**
     *
     */
    public function next (): void
    {
        ++$this->current;
    }

    /**
     * @return int
     */
    public function key (): int
    {
        return $this->current;
    }

    /**
     * @return bool
     */
    public function valid (): bool
    {
        return $this->current < strlen($this->string);
    }

    /**
     *
     */
    public function rewind (): void
    {
        $this->current = 0;
    }
}