<?php

namespace Zer0\Cli\Helpers;

/**
 * Class ArgumentsParser
 *
 * @package Zer0\Cli\Helpers
 */
class ArgumentsParser extends StringIterator
{
    const TOKEN_DOUBLE_QUOTE = '"';
    const TOKEN_SINGLE_QUOTE = "'";
    const TOKEN_SPACE        = ' ';
    const TOKEN_ESCAPE       = '\\';

    /**
     * @return array
     */
    public function parse (): array
    {
        $this->rewind();

        $args = [];

        while ($this->valid()) {
            switch ($this->current()) {
                case self::TOKEN_DOUBLE_QUOTE:
                case self::TOKEN_SINGLE_QUOTE:
                    $args[] = $this->QUOTED($this->current());
                    break;

                case self::TOKEN_SPACE:
                    $this->next();
                    break;

                default:
                    $args[] = $this->UNQUOTED();
            }
        }

        return $args;
    }

    /**
     * @param $enclosure
     *
     * @return string
     */
    private function QUOTED (string $enclosure)
    {
        $this->next();
        $result = '';

        while ($this->valid()) {
            if ($this->current() === self::TOKEN_ESCAPE) {
                $this->next();
                if ($this->valid() && $this->current() === $enclosure) {
                    $result .= $enclosure;
                }
                else if ($this->valid()) {
                    $result .= self::TOKEN_ESCAPE;
                    if ($this->current() !== self::TOKEN_ESCAPE) {
                        $result .= $this->current();
                    }
                }
            }
            else if ($this->current() === $enclosure) {
                $this->next();
                break;
            }
            else {
                $result .= $this->current();
            }
            $this->next();
        }

        return $result;
    }

    /**
     * @return string
     */
    private function UNQUOTED ()
    {
        $result = '';

        while ($this->valid()) {
            if ($this->current() === self::TOKEN_SPACE) {
                $this->next();
                break;
            }
            else {
                $result .= $this->current();
            }
            $this->next();
        }

        return $result;
    }

    /**
     * @param string $input
     *
     * @return array
     */
    public static function parseString (string $input): array
    {
        $parser = new self($input);

        return $parser->parse();
    }
}