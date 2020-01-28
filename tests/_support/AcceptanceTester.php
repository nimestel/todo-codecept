<?php


/**
 * Inherited Methods
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method \Codeception\Lib\Friend haveFriend($name, $actorClass = null)
 *
 * @SuppressWarnings(PHPMD)
 */
class AcceptanceTester extends \Codeception\Actor
{
    use _generated\AcceptanceTesterActions;

    /** Scroll to element and click
     * @param string $locator
     */
    public function clickTo(string $locator): void
    {
        $I = $this;
        $I->scrollTo($locator);
        $I->click($locator);
    }

    /** Scroll to element and check it is visible
     * @param string $locator
     */
    public function seeTo(string $locator): void
    {
        $I = $this;
        $I->scrollTo($locator);
        $I->seeElement($locator);
    }

    /** Clear field and type text
     * Method overriden because geckodriver can't clear field
     * @param $field
     * @param $value
     */
    public function typeText($field, $value): void
    {
        $I = $this;
        $I->pressKey($field, array('ctrl', 'a'), \Facebook\WebDriver\WebDriverKeys::DELETE);
        $I->pressKey($field, array('ctrl', 'a'), \Facebook\WebDriver\WebDriverKeys::DELETE);
        $I->fillField($field, $value);
    }
}
