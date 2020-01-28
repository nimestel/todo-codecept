<?php

use Models\Todo;
use Pages\DeletePage;
use Pages\MainPage;
use Pages\TablePage;
use Pages\TodoCard;

/**
 * Проверяет добавление todo
 *
 * @group desktop
 * @group mobile
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
        TablePage $TablePage
    ): void {
        $I->wantTo('Проверить добавление todo с именем и приоритетом');

        $todo = new Todo(Todo::ADD_WITH_NAME_AND_PRIORITY);
        $TodoCard->add($todo);
        $TablePage->seeTodo($todo);
    }

    /**
     * Открыть главную страницу
     * Повторить добавление два раза:
     *  Нажать на кнопку добавления todo
     *  Заполнить поле title
     *  Нажать на кнопку сохранения
     *
     * В таблице отображаются обе записи с одинаковыми именами и без приоритета
     */
    public function testAddWithSameNameWithoutPriority(
        AcceptanceTester $I,
        TodoCard $TodoCard,
        TablePage $TablePage
    ): void {
        $I->wantTo('Проверить добавление todo с одинаковым именем и без приоритета');

        $todo = new Todo(Todo::ADD_WITH_SAME_NAME_NO_PRIORITY);
        $TodoCard->add($todo);
        $TodoCard->add($todo);

        $I->expect('Успешно создалось две записи с одинаковыми названиями');
        $TablePage->seeNumberOfTodos($todo, 2);
    }

    /**
     * Открыть главную страницу
     * Повторить добавление 10 раз:
     *  Нажать на кнопку добавления todo
     *  Заполнить поле title случайно сгенерированной строкой
     *  Нажать на кнопку сохранения
     *
     * В таблице отображаются все записи
     */
    public function testAddWithRandomName(
        AcceptanceTester $I,
        TodoCard $TodoCard,
        TablePage $TablePage
    ): void {
        $I->wantTo('Проверить добавление todo со случайными именами');

        $todos = [];
        for ($i = 0; $i < 10; $i++) {
            $todos[] = new Todo();
        }

        $TodoCard->addAFew($todos);

        foreach ($todos as $todo) {
            $TablePage->seeTodo($todo);
        }
    }

    public function afterSuite(AcceptanceTester $I, DeletePage $DeletePage)
    {
        $I->wantTo('Очистить записи');
        $DeletePage->deleteAll();
    }
}
