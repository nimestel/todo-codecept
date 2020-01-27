<?php
/**
 * Created by PhpStorm.
 * User: t.chervyakova
 * Date: 27.01.2020
 * Time: 22:13
 */

use Models\Todo;
use Pages\DeletePage;
use Pages\MainPage;
use Pages\TablePage;
use Pages\TodoCard;

/**
 * Проверяет сортировку по основным полям в таблице
 */
class SortByFilterCest
{
    /** Массив записей для сортировки */
    public $todos = [];

    public function _before(MainPage $MainPage): void
    {
        $MainPage->open();
    }

    public function beforeSuite(
        AcceptanceTester $I,
        DeletePage $DeletePage,
        TodoCard $TodoCard
    ): void {
        $I->wantTo('Добавить данные для тестов');

        $this->todos[0] = new Todo(Todo::ADD_FOR_SORT1);
        $this->todos[1] = new Todo(Todo::ADD_FOR_SORT2);
        $this->todos[2] = new Todo(Todo::ADD_FOR_SORT3);
        $this->todos[3] = new Todo(Todo::ADD_FOR_SORT4);

        $DeletePage->deleteAll();
        $TodoCard->addAFew($this->todos);
    }

    /**
     * Открыть главную страницу
     * Проверить, что заголовок таблицы отображается корректно
     * Нажать на заголовок Priority
     *
     * Записи в таблице отображаются в ожидаемом порядке
     */
    public function testSortByPriority(
        AcceptanceTester $I,
        TablePage $TablePage
    ): void {
        $I->wantTo('Проверить сортировку todo по приориту');

        $TablePage->checkHeader();
        //$TablePage->seeRowNumberIs();
    }

    public function afterSuite(AcceptanceTester $I, DeletePage $DeletePage)
    {
        $I->wantTo('Очистить записи');
        $DeletePage->deleteAll();
    }
}