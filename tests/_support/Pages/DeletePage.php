<?php
/**
 * Created by PhpStorm.
 * User: t.chervyakova
 * Date: 26.01.2020
 * Time: 14:37
 */

namespace Pages;

use Models\Todo;

/**
 * Окно подтверждения удаления
 *
 * Class DeletingWindow
 * @package Pages
 */
class DeletePage extends BasePage
{
    public const WINDOW = '.modal-card ';
    public const BTN_DELETE = self::WINDOW . 'button.is-danger';
    public const BTN_CANCEL = self::WINDOW . 'button:not(.is-danger)';

    /**
     * Удалить все todo
     */
    public function deleteAll(): void
    {
        $I = $this->user;
        $MainPage = new MainPage($I);
        $MainPage->openDeleteAllWindow();
        $this->accept();
    }

    /**
     * Удалить конкретное todo
     * @param Todo $model
     */
    public function delete(Todo $model): void
    {
        $I = $this->user;
        $Table = new TablePage($I);
        $Table->openDeleteTodoWindow($model);
        $this->accept();
    }

    /**
     * Нажать на кнопку подтверждения удаления
     */
    public function accept(): void
    {
        $I = $this->user;
        $I->click(static::BTN_DELETE);
        $I->waitForElementNotVisible(static::WINDOW);
    }

    /**
     * Нажать на кнопку отмены удаления
     */
    public function cancel(): void
    {
        $I = $this->user;
        $I->click(static::BTN_CANCEL);
        $I->waitForElementNotVisible(static::WINDOW);
    }
}