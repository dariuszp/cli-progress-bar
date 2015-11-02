<?php

namespace Dariuszp;

class CliProgressBar {

    protected $steps = 1;

    protected $current = 0;

    /**
     * @param int $step
     * @return $this
     */
    public function progress($step = 1) {
        $step = intval($step);
        if (!$step) {
            throw new \InvalidArgumentException('Step value must be above 0');
        }
        if ($this->current < $this->steps) {
            $this->current += intval($step);
        }
        return $this;
    }

    /**
     * @return string
     */
    public function draw() {
        return '';
    }

    public function __toString() {
        return $this->draw();
    }
}