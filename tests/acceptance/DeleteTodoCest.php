<?php

use Models\Todo;
use Pages\DeletePage;
use Pages\MainPage;
use Pages\TablePage;
use Pages\TodoCard;

/**
 * Проверяет удаление todo
 */
class DeleteTodoCest
{

    public function _before(MainPage $MainPage): void
    {
        $MainPage->open();
    }

    /**
     * Подготовка: создать запись
     *
     * Открыть главную страницу
     * Нажать на кнопку удаления todo
     * Нажать на кнопку подтверждения
     *
     * В таблице не отображается удаленная запись
     */
    public function testDeleteOneTodo(
        AcceptanceTester $I,
        TodoCard $TodoCard,
        DeletePage $DeletePage,
        TablePage $TablePage
    ): void {
        $I->wantTo('Проверить удаление одного todo');

        $todo = new Todo();

        $TodoCard->add($todo);
        $DeletePage->delete($todo);

        $TablePage->dontSeeTodo($todo);
    }

    /**
     * Подготовка: создать две записи
     *
     * Открыть главную страницу
     * Нажать на кнопку удаления всех todo
     * Нажать на кнопку подтверждения
     *
     * В таблице не отображаются удаленные записи
     */
    public function testDeleteAllTodos(
        AcceptanceTester $I,
        TodoCard $TodoCard,
        DeletePage $DeletePage,
        TablePage $TablePage
    ): void {
        $I->wantTo('Проверить удаление нескольких todo');

        $todos = [];
        $todos[] = new Todo();
        $todos[] = new Todo();

        $TodoCard->addAFew($todos);
        $DeletePage->deleteAll();

        foreach ($todos as $todo) {
            $TablePage->dontSeeTodo($todo);
        }
    }
}