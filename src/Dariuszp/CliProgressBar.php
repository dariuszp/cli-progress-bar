<?php
declare(strict_types=1);

namespace Dariuszp;

use InvalidArgumentException;

/**
 * Class CliProgressBar
 */
class CliProgressBar
{
    const COLOR_CODE_FORMAT = "\033[%dm";

    /**
     * @var int
     */
    protected $barLength = 40;

    /**
     * @var array|bool
     */
    protected $color = false;

    /**
     * @var int
     */
    protected $steps = 100;

    /**
     * @var int
     */
    protected $currentStep = 0;

    /**
     * @var string
     */
    protected $detail = "";

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

    public function __construct(int $steps = 100,int $currentStep = 0,string $details = "",bool $forceDefaultProgressBar = false)
    {
        $this->setSteps($steps);
        $this->setProgressTo($currentStep);
        $this->setDetails($details);

        // Windows terminal is unable to display utf characters and colors
        if (!$forceDefaultProgressBar && strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            $this->displayDefaultProgressBar();
        }
    }

    /**
     * @param int $currentStep
     * @return $this
     */
    public function setProgressTo(int $currentStep): self
    {
        $this->setCurrentstep($currentStep);
        return $this;
    }

    /**
     * @return $this
     */
    public function displayDefaultProgressBar(): self
    {
        $this->charEmpty = $this->defaultCharEmpty;
        $this->charFull = $this->defaultCharFull;
        return $this;
    }

     /**
     * @param $start
     * @param $end
     * @return $this
     */
    protected function setColor(int $start,int $end): self
    {
        $this->color = array(
            sprintf(self::COLOR_CODE_FORMAT, $start),
            sprintf(self::COLOR_CODE_FORMAT, $end),
        );
        return $this;
    }
    
    /**
     * @return $this
     */
    public function setColorToDefault(): self
    {
        $this->color = false;
        return $this;
    }
    
    /**
    * @return $this
    */
    public function setColorToBlack(): self
    {
        return $this->setColor(30, 39);
    }

    /**
    * @return $this
    */
    public function setColorToRed(): self
    {
        return $this->setColor(31, 39);
    }

    /**
    * @return $this
    */
    public function setColorToGreen(): self
    {
        return $this->setColor(32, 39);
    }

    /**
    * @return $this
    */
    public function setColorToYellow(): self
    {
        return $this->setColor(33, 39);
    }

    /**
    * @return $this
    */
    public function setColorToBlue(): self
    {
        return $this->setColor(34, 39);
    }

    /**
    * @return $this
    */
    public function setColorToMagenta(): self
    {
        return $this->setColor(35, 39);
    }

    /**
    * @return $this
    */
    public function setColorToCyan(): self
    {
        return $this->setColor(36, 39);
    }

    /**
    * @return $this
    */
    public function setColorToWhite(): self
    {
        return $this->setColor(37, 39);
    }

    /**
     * @return string
     */
    public function getDefaultCharEmpty(): string
    {
        return (string) $this->defaultCharEmpty;
    }

    /**
     * @param string $defaultCharEmpty
     * 
     * @return $this
     */
    public function setDefaultCharEmpty(string $defaultCharEmpty): self
    {
        $this->defaultCharEmpty = $defaultCharEmpty;
        return $this;
    }

    /**
     * @return string
     */
    public function getDefaultCharFull(): string
    {
        return $this->defaultCharFull;
    }

    /**
     * @param string $defaultCharFull
     *
     * @return $this
     */
    public function setDefaultCharFull(string $defaultCharFull): self
    {
        $this->defaultCharFull = $defaultCharFull;
        return $this;
    }

    /**
     * @return $this
     */
    public function displayAlternateProgressBar(): self
    {
        $this->charEmpty = $this->alternateCharEmpty;
        $this->charFull = $this->alternateCharFull;
        return $this;
    }

    /**
     * @param int $currentStep
     * @return $this
     */
    public function addCurrentStep(int $currentStep): self
    {
        $this->currentStep += $currentStep;
        return $this;
    }

    /**
     * @return string
     */
    public function getCharEmpty(): string
    {
        return (string) $this->charEmpty;
    }

    /**
     * @param string $charEmpty
     * @return $this
     */
    public function setCharEmpty(string $charEmpty): self
    {
        $this->charEmpty = $charEmpty;
        return $this;
    }

    /**
     * @return string
     */
    public function getCharFull(): string
    {
        return (string) $this->charFull;
    }

    /**
     * @param string $charFull
     * @return $this
     */
    public function setCharFull(string $charFull): self
    {
        $this->charFull = $charFull;
        return $this;
    }

    /**
     * @return string
     */
    public function getAlternateCharEmpty(): string
    {
        return (string) $this->alternateCharEmpty;
    }

    /**
     * @param string $alternateCharEmpty
     * @return $this
     */
    public function setAlternateCharEmpty(string $alternateCharEmpty): self
    {
        $this->alternateCharEmpty = $alternateCharEmpty;
        return $this;
    }

    /**
     * @return string
     */
    public function getAlternateCharFull(): string
    {
        return (string) $this->alternateCharFull;
    }

    /**
     * @param string $alternateCharFull
     * @return $this
     */
    public function setAlternateCharFull(string $alternateCharFull): self
    {
        $this->alternateCharFull = $alternateCharFull;
        return $this;
    }

    /**
     * @param string $details
     * @return $this
     */
    public function setDetails(string $details): self
    {
        $this->detail = $details;
        return $this;
    }

    /**
    * @return string
    */ 
    public function getDetails(): string
    {
        return $this->detail;
    }

    /**
     * @param int $step
     * @param bool $display
     * @return $this
     */
    public function progress(string $step = 1, bool $display = true): self
    {
        $this->setCurrentstep($this->getCurrentStep() + $step);

        if ($display) {
            $this->display();
        }

        return $this;
    }

    /**
     * @return int
     */
    public function getCurrentStep(): int
    {
        return $this->currentStep;
    }

    /**
     * @param int $currentStep
     * @return $this
     */
    public function setCurrentStep(int $currentStep): self
    {
        if ($currentStep < 0) {
            throw new InvalidArgumentException('Current step must be 0 or above');
        }

        $this->currentStep = $currentStep;
        if ($this->currentStep > $this->getSteps()) {
            $this->currentStep = $this->getSteps();
        }
        return $this;
    }

    /**
    * @return void
    */
    public function display(): void
    {
        print $this->draw();
    }

    /**
     * @return string
     */
    public function draw(): string
    {
        $fullValue = floor($this->getCurrentStep() / $this->getSteps() * $this->getBarLength());
        $emptyValue = $this->getBarLength() - $fullValue;
        $prc = number_format(($this->getCurrentStep() / $this->getSteps()) * 100, 1, '.', ' ');

        $colorStart = '';
        $colorEnd = '';
        if ($this->color) {
            $colorStart = $this->color[0];
            $colorEnd = $this->color[1];
        }

        $userDetail = $this->getDetails();
        $userDetail = ((strlen($userDetail) > 1) ? "{$userDetail} " : "");
        $bar = sprintf("%4\$s%5\$s %3\$.1f%% (%1\$d/%2\$d)", $this->getCurrentStep(), $this->getSteps(), $prc, str_repeat($this->charFull, $fullValue), str_repeat($this->charEmpty, $emptyValue));
        return sprintf("\r%s%s%s%s", $colorStart, $userDetail, $bar, $colorEnd);
    }

    /**
     * @return int
     */
    public function getSteps(): int
    {
        return $this->steps;
    }

    /**
     * @param int $steps
     * @return $this
     */
    public function setSteps(int $steps): self
    {
        if ($steps < 0) {
            throw new InvalidArgumentException('Steps amount must be 0 or above');
        }

        $this->steps = $steps;

        $this->setCurrentStep($this->getCurrentStep());

        return $this;
    }

    /**
     * @return int
     */
    public function getBarLength(): int
    {
        return $this->barLength;
    }

    /**
     * @param $barLength
     * @return $this
     */
    public function setBarLength(int $barLength): self
    {
        if ($barLength < 1) {
            throw new InvalidArgumentException('Progress bar length must be above 0');
        }
        $this->barLength = $barLength;
        return $this;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->draw();
    }

    /**
     * Alias to new line (nl)
     *
     * @return void
     */
    public function end(): void
    {
        $this->nl();
    }

    /**
     * display new line
     *
     * @return void
     */
    public function nl(): void
    {
        print "\n";
    }
}
