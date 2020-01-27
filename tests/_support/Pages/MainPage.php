<?php
/**
 * Created by PhpStorm.
 * User: t.chervyakova
 * Date: 26.01.2020
 * Time: 14:38
 */

namespace Pages;

/**
 * Главная страница
 *
 * Class MainPage
 * @package Pages
 */
class MainPage extends BasePage
{
    public const TITLE = "//h1[.='Todo App']";
    public const SUBTITLE = "//h2[normalize-space()='A todo list']";
    public const BTN_ADD_TODO = 'button.is-primary';
    public const BTN_DELETE_ALL = 'button.is-warning';

    /**
     * Переход на страницу приложения
     */
    public function open(): void
    {
        $this->user->amOnPage('/');
    }

    /**
     * Проверить видимость ключевых элементов
     */
    public function checkElements(): void
    {
        $I = $this->user;
        $I->waitForElementVisible(static::TITLE);
        $I->waitForElementVisible(static::SUBTITLE);
        $I->waitForElementVisible(static::BTN_ADD_TODO);
        $I->waitForElementVisible(static::BTN_DELETE_ALL);
    }

    /**
     * Открыть окно добавления записи
     * @return TodoCard
     */
    public function openAddTodoWindow(): TodoCard
    {
        $I = $this->user;
        $I->clickTo(static::BTN_ADD_TODO);

        return new TodoCard($I);
    }

    /**
     * Открыть окно удаления всех записей
     * @return DeletePage
     */
    public function openDeleteAllWindow(): DeletePage
    {
        $I = $this->user;
        $I->clickTo(static::BTN_DELETE_ALL);

        return new DeletePage($I);
    }
}