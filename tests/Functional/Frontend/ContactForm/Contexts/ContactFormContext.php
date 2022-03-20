<?php

namespace App\Tests\Functional\Frontend\ContactForm\Contexts;

use Behat\Behat\Context\Context;
use Behat\Mink\Element\NodeElement;
use Behat\MinkExtension\Context\RawMinkContext;
use PHPUnit\Framework\Assert;

class ContactFormContext extends RawMinkContext implements Context
{
    /**
     * @When /^I type "([^"]*)" in "([^"]*)"$/
     */
    public function iTypeIn($text, $label)
    {
        $elements = [
            'Full name' => 'Full name', // Label
            'E-mail' => 'chuck_norris@hitme.com', // PlaceHolder
            'Subject' => 'contact_form[subject]', // NAME
        ];

        $page = $this->getSession()->getPage();
        $locator = $elements[$label];

        $nodeElement = $page->findField($locator);
        $nodeElement->setValue($text);
    }

    /**
     * @When /^I submit the contact form$/
     */
    public function iSubmitTheContactForm()
    {
        $this->getSession()->getPage()->pressButton('Send Contact Form Request');
    }

    /**
     * @Then /^I should see an error message next to "([^"]*)"$/
     */
    public function esteMetodoPuedeLlamarseComoSeDesee($error)
    {
        /** @var NodeElement[] $errorNodes */
        $errorNodes = $this->getSession()->getPage()->findAll('css', '.form-error-icon');
        Assert::assertNotEmpty(count($errorNodes), 'No error mask was found');

        $found = false;
        foreach ($errorNodes as $errorNode) {
            // Inspeccionar en Elements de la consola de Chrome para averiguar cómo se montan los elementos
            $strippedHtmlTagsTextToFind = 'Error' . ' ' . $error;
            if ($errorNode->getParent()->getText() == $strippedHtmlTagsTextToFind) {
                $found = true;
                break;
            }
        }

        Assert::assertTrue($found, sprintf('A mark should be found next to the text %s', $error));
    }

    /**
     * @When I enable javascript validation
     */
    public function iEnableJavascriptValidation()
    {
        // add the 'needs-validation' class to the form for enabling Javascript Validation
        $this->getSession()->executeScript("document.getElementById('contact_form').classList.add('needs-validation')");
        echo "A: " . $this->getSession()->getPage()->findById('contact_form')->getAttribute('class');
    }


    /**
     * @Then /^I should see "([^"]*)" only once$/
     */
    public function iShouldSeeOnlyOnce($text)
    {
        $nodes = $this->getSession()->getPage()->findAll('named', ['content', $text]);
        Assert::assertEquals(1, count($nodes));
    }
}
