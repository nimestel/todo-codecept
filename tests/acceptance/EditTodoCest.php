<?php

use Models\Todo;
use Pages\DeletePage;
use Pages\MainPage;
use Pages\TablePage;
use Pages\TodoCard;

/**
 * Проверяет редактирование todo
 */
class EditTodoCest
{
    public function _before(MainPage $MainPage): void
    {
        $MainPage->open();
    }

    /**
     * Подготовка: создать запись с именем и приоритетом
     *
     * Открыть главную страницу
     * Нажать на кнопку редактирования записи в таблице
     * Заполнить поля title и priority
     * Нажать на кнопку сохранения
     *
     * В таблице отображается измененная запись
     */
    public function testEditNameAndPriority(
        AcceptanceTester $I,
        TodoCard $TodoCard,
        TablePage $TablePage
    ): void {
        $I->wantTo('Проверить изменение названия и приоритета todo с именем и приоритетом');

        $todoAdd = new Todo(Todo::ADD_WITH_NAME_AND_PRIORITY);
        $todoEdit = new Todo(Todo::EDIT_NAME_AND_PRIORITY);

        $TodoCard->add($todoAdd);

        $TodoCard->edit($todoAdd, $todoEdit);
        $TablePage->seeTodo($todoEdit);
    }

    /**
     * Подготовка: создать запись с именем и приоритетом
     *
     * Открыть главную страницу
     * Нажать на кнопку редактирования записи в таблице
     * Заполнить поле title
     * Нажать на кнопку сохранения
     *
     * В таблице отображается измененная запись с прежним приоритетом
     */
    public function testEditNameTodoWithPriority(
        AcceptanceTester $I,
        TodoCard $TodoCard,
        TablePage $TablePage
    ): void {
        $I->wantTo('Проверить изменение названия todo с именем и приоритетом');

        $todoAdd = new Todo(Todo::ADD_WITH_NAME_AND_PRIORITY);
        $priorityBefore = $todoAdd->getPriority();

        $I->comment('После изменения названия у todo останется прежний приоритет');
        $todoEdit = new Todo(Todo::EDIT_NAME);
        $todoAfterEdit = new Todo(Todo::EDIT_NAME);
        $todoAfterEdit->setPriority($priorityBefore);

        $TodoCard->add($todoAdd);

        $TodoCard->edit($todoAdd, $todoEdit);
        $TablePage->seeTodo($todoAfterEdit);
    }

    /**
     * Подготовка: создать запись с именем и без приоритета
     *
     * Открыть главную страницу
     * Нажать на кнопку редактирования записи в таблице
     * Заполнить поле title
     * Нажать на кнопку сохранения
     *
     * В таблице отображается измененная запись
     * В таблице не отображается прежняя запись
     */
    public function testEditNameTodoNoPriority(
        AcceptanceTester $I,
        TodoCard $TodoCard,
        TablePage $TablePage
    ): void {
        $I->wantTo('Проверить изменение названия todo с приоритетом');

        $I->amGoingTo('Создать todo со случайным именем');
        $todoAdd = new Todo();
        $todoAdd->setRandomName();
        $todoEdit = new Todo(Todo::EDIT_NAME);

        $TodoCard->add($todoAdd);

        $TodoCard->edit($todoAdd, $todoEdit);
        $TablePage->seeTodo($todoEdit);
        $TablePage->dontSeeTodo($todoAdd);
    }

    /**
     * Подготовка: создать запись с именем и приоритетом
     *
     * Открыть главную страницу
     * Нажать на кнопку редактирования записи в таблице
     * Заполнить поле priority
     * Нажать на кнопку сохранения
     *
     * В таблице отображается измененная запись
     */
    public function testEditPriorityTodoWithNameAndPriority(
        AcceptanceTester $I,
        TodoCard $TodoCard,
        TablePage $TablePage
    ): void {
        $I->wantTo('Проверить изменение приоритета todo с именем и приоритетом');

        $todoAdd = new Todo(Todo::ADD_WITH_NAME_AND_PRIORITY);
        $nameBefore = $todoAdd->getName();

        $I->comment('После изменения приоритета у todo останется прежнее название');
        $todoEdit = new Todo(Todo::EDIT_PRIORITY);
        $todoAfterEdit = new Todo(Todo::EDIT_PRIORITY);
        $todoAfterEdit->setName($nameBefore);

        $TodoCard->add($todoAdd);

        $TodoCard->edit($todoAdd, $todoEdit);
        $TablePage->seeTodo($todoAfterEdit);
    }

    public function afterSuite(AcceptanceTester $I, DeletePage $DeletePage)
    {
        $I->wantTo('Очистить записи');
        $DeletePage->deleteAll();
    }
}
