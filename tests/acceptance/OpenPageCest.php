<?php

use Pages\MainPage;

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
     * @param AcceptanceTester $I
     * @throws Exception
     */
    public function testOpenMainPage(AcceptanceTester $I, MainPage $MainPage): void
    {
        $I->wantTo('Проверить главную страницу');

        $MainPage->open();
        $MainPage->checkElements();
    }
}