# cli-progress-bar [![Build Status](https://travis-ci.org/dariuszp/cli-progress-bar.png?branch=master)](https://travis-ci.org/dariuszp/cli-progress-bar)
Progress bar for cli apps

![example animation](examples/img/terminal.gif)

## Installation

```bash
composer require dariuszp/cli-progress-bar
```

## Usage

```php
use Dariuszp\CliProgressBar;
$bar = new CliProgressBar(10, 5);
$bar->display();
$bar->end();
```

Code above will show half full progress bar:

```
▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓░░░░░░░░░░░░░░░░░░░░ 50.0% (5/10)
```

Windows can't handle some UTF characters so there is an alternate method to display progress bar:

```php
use Dariuszp\CliProgressBar;
$bar = new CliProgressBar();
$bar->displayAlternateProgressBar(); // this only switch style

$bar->display();
$bar->end();
```

Output will be:

```
XXXX____________________________________ 10.0% (10/100)
```

Add text to the progress bar using the following methods
```php
use Dariuszp\CliProgressBar;
$bar = new CliProgressBar(50, 0, "My Custom Text");
$bar->display();
$bar->end();
```
or
```php
use Dariuszp\CliProgressBar;
$bar = new CliProgressBar();
$bar->setDetails("My Custom Text");
$bar->display();
$bar->end();
```

Also update asynchronously with setDetails()

More features like:
- changing progress bar length (basicWithShortBar.php)
- changing bar color (colors.php)
- animation example (basic.php)
- etc...

in [example](examples/) directory.

----

License: [MIT](https://opensource.org/licenses/MIT)

Author: Półtorak Dariusz
Contributors: [@mathmatrix828 - Mason Phillips](https://github.com/mathmatrix828/)
