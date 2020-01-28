<?php

use Pages\MainPage;
use Pages\TablePage;
use PHPUnit\Framework\Constraint\IsEmpty;

/**
 * Проверяет главную страницу
 */
class OpenPageCest
{
    /**
     * Открыть главную страницу
     * Проверить наличие на странице:
     * - заголовков
     * - кнопки добавления
     * - кнопки удаления
     *
     * @group desktop
     */
    public function testOpenMainPageDesktop(AcceptanceTester $I, MainPage $MainPage): void
    {
        $I->wantTo('Проверить главную страницу в десктопной версии');

        $MainPage->open();
        $MainPage->checkElements();
    }

    /**
     * Открыть главную страницу
     * Проверить наличие на странице:
     * - заголовков
     * - кнопки добавления
     * - кнопки удаления
     * - кнопки сортировки
     * - поля сортировки
     * - таблицы
     *
     * @group mobile
     */
    public function testOpenMainPageMobile(AcceptanceTester $I, MainPage $MainPage, TablePage $TablePage): void
    {
        $I->wantTo('Проверить главную страницу в мобильной версии');

        $MainPage->open();
        $MainPage->checkElementsMobile();
    }
}