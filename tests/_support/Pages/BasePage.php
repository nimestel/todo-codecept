<?php
/**
 * Created by PhpStorm.
 * User: t.chervyakova
 * Date: 26.01.2020
 * Time: 14:33
 */

namespace Pages;

/**
 * Базовый класс для PageObject страниц.
 *
 * Class BasePage
 * @package Pages
 */
class BasePage
{
    /**
     * @var \AcceptanceTester
     */
    protected $user;

    public function __construct(\AcceptanceTester $I)
    {
        $this->user = $I;
    }
}