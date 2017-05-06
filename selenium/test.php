<?php
/**
 * Created by PhpStorm.
 * Date: 06/05/17
 */

require_once(__DIR__ . '/../vendor/autoload.php');

use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverExpectedCondition;

class SeleniumAuthTest
{
    public $driver;

    public function __construct()
    {
        $this->driver = RemoteWebDriver::create('http://localhost:9515/', DesiredCapabilities::chrome());
    }

    public function testInvalidCredentials()
    {
        $login = 'invalid-email';
        $password = 'invalid-password';

        $this->driver->get("http://contest.local:8000/");
        $this->driver->findElement(WebDriverBy::linkText('Вход'))->click();

        $this->driver->findElement(WebDriverBy::id('loginform-email'))->sendKeys($login);
        $this->driver->findElement(WebDriverBy::id('loginform-password'))->sendKeys($password);

        $this->driver->findElement(WebDriverBy::name('login-button'))->click();

        $this->driver->wait(3)->until(
            WebDriverExpectedCondition::presenceOfElementLocated(
                WebDriverBy::cssSelector('.alert-warning')
            )
        );
    }

    public function testValidCredentials()
    {
        $login = 'admin@gmail.com';
        $password = '12345678';

        $this->driver->get("http://contest.local:8000/");
        $this->driver->findElement(WebDriverBy::linkText('Вход'))->click();

        $this->driver->findElement(WebDriverBy::id('loginform-email'))->sendKeys($login);
        $this->driver->findElement(WebDriverBy::id('loginform-password'))->sendKeys($password);

        $this->driver->findElement(WebDriverBy::name('login-button'))->click();

        $this->driver->wait(3)->until(
            WebDriverExpectedCondition::presenceOfElementLocated(
                WebDriverBy::cssSelector('.alert-success')
            )
        );

    }
}

$selenium = new SeleniumAuthTest();
$selenium->testInvalidCredentials();
$selenium->testValidCredentials();