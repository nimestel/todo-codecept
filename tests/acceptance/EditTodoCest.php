<?php

use Models\Todo;
use Pages\DeletePage;
use Pages\MainPage;
use Pages\TablePage;
use Pages\TodoCard;

/**
 * Проверяет редактирование todo
 *
 * @group desktop
 * @group mobile
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

        $todoAdd = new Todo(Todo::ADD_FOR_EDIT);
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
    public function testEditNameInFullTodo(
        AcceptanceTester $I,
        TodoCard $TodoCard,
        TablePage $TablePage
    ): void {
        $I->wantTo('Проверить изменение названия todo с именем и приоритетом');

        $todoAdd = new Todo(Todo::ADD_FOR_EDIT);
        $todoEdit = new Todo(Todo::EDIT_NAME);

        $I->comment('После изменения названия у todo останется прежний приоритет');
        $priorityBefore = $todoAdd->getPriority();
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
    public function testEditNameInTodoWithoutPriority(
        AcceptanceTester $I,
        TodoCard $TodoCard,
        TablePage $TablePage
    ): void {
        $I->wantTo('Проверить изменение названия todo без приоритета');

        $todoAdd = new Todo();
        $todoEdit = new Todo();

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
    public function testEditPriorityInFullTodo(
        AcceptanceTester $I,
        TodoCard $TodoCard,
        TablePage $TablePage
    ): void {
        $I->wantTo('Проверить изменение приоритета todo с именем и приоритетом');

        $todoAdd = new Todo(Todo::ADD_FOR_EDIT);
        $todoEdit = new Todo(Todo::EDIT_PRIORITY);

        $I->comment('После изменения приоритета у todo останется прежнее название');
        $nameBefore = $todoAdd->getName();
        $todoAfterEdit = new Todo(Todo::EDIT_PRIORITY);
        $todoAfterEdit->setName($nameBefore);

        $TodoCard->add($todoAdd);
        $TodoCard->edit($todoAdd, $todoEdit);

        $TablePage->seeTodo($todoAfterEdit);
    }

    /**
     * Подготовка: создать запись без приоритета
     *
     * Открыть главную страницу
     * Нажать на кнопку редактирования записи в таблице
     * Заполнить поле priority
     * Нажать на кнопку сохранения
     *
     * В таблице отображается измененная запись
     */
    public function testEditPriorityInTodoWithoutPriority(
        AcceptanceTester $I,
        TodoCard $TodoCard,
        TablePage $TablePage
    ): void {
        $I->wantTo('Проверить изменение приоритета todo без приоритета');

        $todoAdd = new Todo();
        $todoEdit = new Todo(Todo::EDIT_PRIORITY);

        $I->comment('После изменения приоритета у todo останется прежнее название');
        $nameBefore = $todoAdd->getName();
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
