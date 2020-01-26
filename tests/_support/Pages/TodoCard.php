<?php
/**
 * Created by PhpStorm.
 * User: t.chervyakova
 * Date: 26.01.2020
 * Time: 14:34
 */

namespace Pages;

use Models\Todo;

/**
 * Карточка заполнения
 *
 * Class TodoCard
 * @package Pages
 */
class TodoCard extends MainPage
{
    public const CARD = "//*[@class='modal-card']";
    public const FLD_TITLE = self::CARD . "//*[contains(@class, 'is-clearfix')]//input";
    public const FLD_PRIORITY = self::CARD . "//label[.='Priority']/following-sibling::div//select";
    public const BTN_CLOSE = self::CARD . "//button[contains(text(),'Close')]";
    public const BTN_SAVE = self::CARD . "//button[contains(@class,'is-primary')]";
    public const BTN_CLOSE_LARGE = 'button.modal-close.is-large';

    public function add(Todo $model): void
    {
        $I = $this->user;
        $MainPage = new MainPage($I);
        $MainPage->openAddTodoWindow();
        $this->fillFields($model);
        $this->save();
    }

    public function save(): void
    {
        $I = $this->user;
        $I->click(static::BTN_SAVE);
        $I->waitForElementNotVisible(static::CARD);
    }

    public function close(): void
    {
        $I = $this->user;
        $I->click(static::BTN_CLOSE);
        $I->waitForElementNotVisible(static::CARD);
    }

    public function cancel(): void
    {
        $I = $this->user;
        $I->click(static::BTN_CLOSE_LARGE);
        $I->waitForElementNotVisible(static::CARD);
    }

    public function fillFields(Todo $model): void
    {
        $I = $this->user;
        $I->fillField(static::FLD_TITLE, $model->getName());
        $I->selectOption(static::FLD_PRIORITY, $model->getPriority());
    }
}