<?php

use Models\Todo;
use Pages\DeletePage;
use Pages\MainPage;
use Pages\TablePage;
use Pages\TodoCard;

/**
 * Проверяет закрытие окна без совершения изменений
 *
 * @group desktop
 * @group mobile
 */
class CloseWindowCest
{
    public function _before(MainPage $MainPage): void
    {
        $MainPage->open();
    }

    /**
     * Подготовка: создать запись
     *
     * Открыть главную страницу
     * Нажать на кнопку редактирования записи в таблице
     * Нажать на кнопку отмены
     *
     * В таблице отображается исходная запись
     */
    public function testCloseForEditWindow(
        AcceptanceTester $I,
        TodoCard $TodoCard,
        TablePage $TablePage
    ): void {
        $I->wantTo('Проверить закрытие окна изменения todo');

        $todo = new Todo();

        $TodoCard->add($todo);
        $TablePage->openEditTodoWindow($todo);
        $TodoCard->close();

        $TablePage->seeTodo($todo);
    }

    /**
     * Подготовка: создать запись
     *
     * Открыть главную страницу
     * Нажать на кнопку удаления записи в таблице
     * Нажать на кнопку отмены
     *
     * В таблице отображается исходная запись
     */
    public function testCloseForDeleteWindow(
        AcceptanceTester $I,
        TodoCard $TodoCard,
        DeletePage $DeletePage,
        TablePage $TablePage
    ): void {
        $I->wantTo('Проверить закрытие окна удаления todo');

        $todo = new Todo();

        $TodoCard->add($todo);
        $TablePage->openDeleteTodoWindow($todo);
        $DeletePage->cancel();

        $TablePage->seeTodo($todo);
    }

    /**
     * Подготовка: создать несколько записей
     *
     * Открыть главную страницу
     * Нажать на кнопку удаления всех записей
     * Нажать на кнопку отмены
     *
     * В таблице отображаются исходные записи
     */
    public function testCloseForDeleteAllWindow(
        AcceptanceTester $I,
        MainPage $MainPage,
        TodoCard $TodoCard,
        DeletePage $DeletePage,
        TablePage $TablePage
    ): void {
        $I->wantTo('Проверить закрытие окна удаления всех todo');

        $todos = [];
        $todos[] = new Todo();
        $todos[] = new Todo();

        $TodoCard->addAFew($todos);
        $MainPage->openDeleteAllWindow();
        $DeletePage->cancel();

        foreach ($todos as $todo) {
            $TablePage->seeTodo($todo);
        }
    }
}