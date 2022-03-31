<?php
declare(strict_types=1);

namespace App\Tests\Functional\Backend\Workflow\Context;

use App\Tests\Common\Context\UtilsRawContext;
use Behat\MinkExtension\Context\RawMinkContext;

# HEREDAR DE UtilsRawContext, Para poder tomar pantallazos  => final class WorkflowContext extends UtilsRawContext
final class WorkflowContext extends UtilsRawContext
{
    /**
     * @Given I press on the Navigation Toggler
     */
    public function iPressOnTheNavigationToggler()
    {
        $this->getSession()->getPage()->findById('navigation-toggler')->click();
    }

    /**
     * @Then I fill the WYSIWYG :field with :value
     */
    public function iFillTheWysiwygWith($field, $value)
    {
        $page = $this->getSession()->getPage();

        // Find the input editor.
        $label = $page->find('xpath', sprintf("//label[text()='%s']", $field));
        $editor = $label->getParent()->find('css', 'div');
        $input = $editor->find('css', 'trix-editor');

        $input->setValue($value);
    }
}
