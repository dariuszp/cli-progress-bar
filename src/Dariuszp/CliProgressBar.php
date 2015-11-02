<?php

namespace Dariuszp;

/**
 * Class CliProgressBar
 * @package Dariuszp
 */
class CliProgressBar
{
    protected $barLength = 100;
    /**
     * @var string|bool
     */
    protected $color = false;
    /**
     * @var int
     */
    protected $steps = 1;
    /**
     * @var int
     */
    protected $current = 0;
    /**
     * @var string
     */
    protected $charEmpty = '░';
    /**
     * @var string
     */
    protected $charFull = '▓';
    /**
     * @var string
     */
    protected $defaultCharEmpty = '░';
    /**
     * @var string
     */
    protected $defaultCharFull = '▓';
    /**
     * @var string
     */
    protected $alternateCharEmpty = '_';
    /**
     * @var string
     */
    protected $alternateCharFull = 'X';

    public function __construct($steps = 100, $current = 0, $forceDefaultProgressBar = false)
    {
        $this->setProgressTo($current);
        $this->setSteps($steps);

        // Windows terminal is unable to display utf characters and colors
        if (!$forceDefaultProgressBar && strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            $this->displayDefaultProgressBar();
        }
    }

    public function setProgressTo($current)
    {
        $current = intval($current);
        if ($current < 0) {
            throw new \InvalidArgumentException('Current step must be 0 or above');
        }

        if ($current > $this->getSteps()) {
            $current = $this->getSteps();
        }

        $this->current = $current;
    }

    /**
     * @return int
     */
    public function getSteps()
    {
        return $this->steps;
    }

    /**
     * @param int $steps
     * @return $this
     */
    public function setSteps($steps)
    {
        $steps = intval($steps);
        if ($steps < 0) {
            throw new \InvalidArgumentException('Steps amount must be 0 or above');
        }

        $this->steps = intval($steps);
        return $this;
    }

    /**
     * @return $this
     */
    public function displayDefaultProgressBar()
    {
        $this->charEmpty = $this->defaultCharEmpty;
        $this->charFull = $this->defaultCharFull;
        return $this;
    }

    /**
     * @return string
     */
    public function getDefaultCharEmpty()
    {
        return $this->defaultCharEmpty;
    }

    /**
     * @param string $defaultCharEmpty
     */
    public function setDefaultCharEmpty($defaultCharEmpty)
    {
        $this->defaultCharEmpty = $defaultCharEmpty;
    }

    /**
     * @return string
     */
    public function getDefaultCharFull()
    {
        return $this->defaultCharFull;
    }

    /**
     * @param string $defaultCharFull
     */
    public function setDefaultCharFull($defaultCharFull)
    {
        $this->defaultCharFull = $defaultCharFull;
    }

    /**
     * @return $this
     */
    public function displayAlternateProgressBar()
    {
        $this->charEmpty = $this->alternateCharEmpty;
        $this->charFull = $this->alternateCharFull;
        return $this;
    }

    /**
     * @return string|bool
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * @param string|boolean $color
     */
    public function setColor($color)
    {
        $this->color = $color;
    }

    /**
     * @param int $current
     * @return $this
     */
    public function addCurrent($current)
    {
        $this->current += intval($current);
        return $this;
    }

    /**
     * @return string
     */
    public function getCharEmpty()
    {
        return $this->charEmpty;
    }

    /**
     * @param string $charEmpty
     * @return $this
     */
    public function setCharEmpty($charEmpty)
    {
        $this->charEmpty = $charEmpty;
        return $this;
    }

    /**
     * @return string
     */
    public function getCharFull()
    {
        return $this->charFull;
    }

    /**
     * @param string $charFull
     * @return $this
     */
    public function setCharFull($charFull)
    {
        $this->charFull = $charFull;
        return $this;
    }

    /**
     * @return string
     */
    public function getAlternateCharEmpty()
    {
        return $this->alternateCharEmpty;
    }

    /**
     * @param string $alternateCharEmpty
     * @return $this
     */
    public function setAlternateCharEmpty($alternateCharEmpty)
    {
        $this->alternateCharEmpty = $alternateCharEmpty;
        return $this;
    }

    /**
     * @return string
     */
    public function getAlternateCharFull()
    {
        return $this->alternateCharFull;
    }

    /**
     * @param string $alternateCharFull
     * @return $this
     */
    public function setAlternateCharFull($alternateCharFull)
    {
        $this->alternateCharFull = $alternateCharFull;
        return $this;
    }

    /**
     * @param int $step
     * @param bool $display
     * @return $this
     */
    public function progress($step = 1, $display = true)
    {
        $step = intval($step);
        if (!$step) {
            throw new \InvalidArgumentException('Step value must be above 0');
        }
        if ($this->current < $this->steps) {
            $this->current += intval($step);
        }

        if ($display) {
            $this->display();
        }

        return $this;
    }

    public function display()
    {
        print $this->draw();
    }

    /**
     * @return string
     */
    public function draw()
    {
        $emptyValue = floor($this->getCurrent() / $this->getSteps()) * $this->getBarLength();
        $fullValue = $this->getBarLength() - $emptyValue;
        $prc = number_format(($this->getCurrent() / $this->getSteps()) * 100, 1, '.', ' ');

        return sprintf("\r%$4s%$5s %$3f%% (%$1d/%$2d)", $this->getCurrent(), $this->getSteps(), $prc, $emptyValue, $fullValue);
    }

    /**
     * @return int
     */
    public function getCurrent()
    {
        return $this->current;
    }

    /**
     * @param int $current
     * @return $this
     */
    public function setCurrent($current)
    {
        $this->current = intval($current);
        return $this;
    }

    /**
     * @return int
     */
    public function getBarLength()
    {
        return $this->barLength;
    }

    /**
     * @param $barLength
     * @return $this
     */
    public function setBarLength($barLength)
    {
        $barLength = intval($barLength);
        if ($barLength < 1) {
            throw new \InvalidArgumentException('Progress bar length must be above 0');
        }
        $this->barLength = $barLength;
        return $this;
    }

    public function __toString()
    {
        return $this->draw();
    }

    public function end()
    {
        $this->nl();
    }

    public function nl()
    {
        print "\n";
    }
}