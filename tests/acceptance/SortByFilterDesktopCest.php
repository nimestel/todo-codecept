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
class SortByFilterDesktopCest
{
    /** Массив записей для сортировки */
    public $todos = [];

    public function _before(MainPage $MainPage): void
    {
        $MainPage->open();
    }

    public function beforeSuite(
        AcceptanceTester $I,
        MainPage $MainPage,
        DeletePage $DeletePage,
        TodoCard $TodoCard
    ): void {
        $I->wantTo('Добавить данные для тестов');

        $this->todos[0] = new Todo(Todo::ADD_FOR_SORT1);
        $this->todos[1] = new Todo(Todo::ADD_FOR_SORT2);
        $this->todos[2] = new Todo(Todo::ADD_FOR_SORT3);
        $this->todos[3] = new Todo(Todo::ADD_FOR_SORT4);

        $MainPage->open();
        $DeletePage->deleteAll();
        $TodoCard->addAFew($this->todos);
    }

    /**
     * Открыть главную страницу
     * Проверить, что заголовок таблицы отображается корректно
     * Нажать на заголовок Todo
     *
     * Записи в таблице отображаются по возрастанию имени
     *
     * @depends beforeSuite
     */
    public function testSortNameByAsc(
        AcceptanceTester $I,
        TablePage $TablePage
    ): void {
        $I->wantTo('Проверить сортировку todo по возрастанию имени');

        $TablePage->checkHeader();
        $TablePage->sortByNameDesktop();

        $I->expect('1) цифры по возрастанию');
        $TablePage->seeRowNumberIs($this->todos[0], 1);
        $I->expect('2) цифры по возрастанию, затем буквы по возрастанию');
        $TablePage->seeRowNumberIs($this->todos[1], 2);
        $I->expect('3) буквы по возрастанию, затем цифры по возрастанию');
        $TablePage->seeRowNumberIs($this->todos[2], 3);
        $I->expect('4) буквы по возрастанию');
        $TablePage->seeRowNumberIs($this->todos[3], 4);

    }

    /**
     * Открыть главную страницу
     * Проверить, что заголовок таблицы отображается корректно
     * Два раза нажать на заголовок Todo
     *
     * Записи в таблице отображаются по убыванию имени
     *
     * @depends beforeSuite
     */
    public function testSortNameByDesc(
        AcceptanceTester $I,
        TablePage $TablePage
    ): void {
        $I->wantTo('Проверить сортировку todo по убыванию имени');

        $TablePage->checkHeader();
        $TablePage->sortByNameDesktop();
        $TablePage->sortByNameDesktop();

        $I->expect('1) буквы по убыванию');
        $TablePage->seeRowNumberIs($this->todos[3], 1);
        $I->expect('2) буквы по убыванию, затем цифры по убыванию');
        $TablePage->seeRowNumberIs($this->todos[2], 2);
        $I->expect('3) цифры по убыванию, затем буквы по убыванию');
        $TablePage->seeRowNumberIs($this->todos[1], 3);
        $I->expect('4) цифры по убыванию');
        $TablePage->seeRowNumberIs($this->todos[0], 4);
    }

    /**
     * Открыть главную страницу
     * Проверить, что заголовок таблицы отображается корректно
     * Дважды нажать на заголовок Priority
     *
     * Записи в таблице отображаются по возрастанию приоритета
     *
     * @depends beforeSuite
     */
    public function testSortPriorityByAsc(
        AcceptanceTester $I,
        TablePage $TablePage
    ): void {
        $I->wantTo('Проверить сортировку todo по возрастанию приоритета');

        $TablePage->checkHeader();
        $TablePage->sortByPriorityDesktop();
        $TablePage->sortByPriorityDesktop();

        $I->expect('1) meh');
        $TablePage->seeRowNumberIs($this->todos[0], 1);
        $I->expect('2) secondary');
        $TablePage->seeRowNumberIs($this->todos[1], 2);
        $I->expect('3) important');
        $TablePage->seeRowNumberIs($this->todos[2], 3);
        $I->expect('4) без приоритета');
        $TablePage->seeRowNumberIs($this->todos[3], 4);
    }

    /**
     * Открыть главную страницу
     * Проверить, что заголовок таблицы отображается корректно
     * Нажать на заголовок Priority
     *
     * Записи в таблице отображаются по убыванию приоритета
     *
     * @depends beforeSuite
     */
    public function testSortPriorityByDesc(
        AcceptanceTester $I,
        TablePage $TablePage
    ): void {
        $I->wantTo('Проверить сортировку todo по убыванию приоритета');

        $TablePage->checkHeader();
        $TablePage->sortByPriorityDesktop();

        $I->expect('1) important');
        $TablePage->seeRowNumberIs($this->todos[0], 1);
        $I->expect('2) secondary');
        $TablePage->seeRowNumberIs($this->todos[1], 2);
        $I->expect('3) meh');
        $TablePage->seeRowNumberIs($this->todos[2], 3);
        $I->expect('4) без приоритета');
        $TablePage->seeRowNumberIs($this->todos[3], 4);
    }

    public function afterSuite(AcceptanceTester $I, DeletePage $DeletePage)
    {
        $I->wantTo('Очистить записи');
        $DeletePage->deleteAll();
    }
}