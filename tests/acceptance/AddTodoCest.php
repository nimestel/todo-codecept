<?php

use Models\Todo;
use Pages\MainPage;
use Pages\Table;
use Pages\TodoCard;

/**
 * Проверяет добавление todo
 */
class AddTodoCest
{

    public function _before(MainPage $MainPage): void
    {
        $MainPage->open();
    }

    /**
     * Открыть главную страницу
     * Нажать на кнопку добавления todo
     * Заполнить поля title и priority
     * Нажать на кнопку сохранения
     *
     * В таблице отображается сохраненная запись
     */
    public function testAddWithNameAndPriority(
        AcceptanceTester $I,
        TodoCard $TodoCard,
        Table $Table): void
    {
        $I->wantTo('Проверить добавление todo с именем и приоритетом');

        $todo = new Todo(Todo::ADD_WITH_NAME_AND_PRIORITY);
        $TodoCard->add($todo);
        $Table->seeTodo($todo);
    }

    /**
     * Повторить добавление два раза:
     *  Открыть главную страницу
     *  Нажать на кнопку добавления todo
     *  Заполнить поле title
     *  Нажать на кнопку сохранения
     *
     * В таблице отображаются обе записи с одинаковыми именами и без приоритета
     */
    public function testAddWithSameNameWithoutPriority(
        AcceptanceTester $I,
        TodoCard $TodoCard,
        Table $Table): void
    {
        $I->wantTo('Проверить добавление todo с одинаковым именем и без приоритета');

        $todo = new Todo(Todo::ADD_WITH_SAME_NAME_NO_PRIORITY);
        $TodoCard->add($todo);
        $TodoCard->add($todo);

        $I->expect('Успешно создалось две записи с одинаковыми названиями');
        $Table->seeNumberOfTodos($todo, 2);
    }
}