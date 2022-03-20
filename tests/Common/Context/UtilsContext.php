<?php

declare(strict_types=1);

namespace App\Tests\Common\Context;

use Behat\Behat\Hook\Scope\AfterStepScope;

final class UtilsContext extends UtilsRawContext
{
    /** @AfterStep */
    public function takeScreenShotAfterFailedStep(AfterStepScope $scope)
    {
        if (99 === $scope->getTestResult()->getResultCode()) {
            $this->takeAScreenShot('error');
        }
    }

    /** @When /^I take a screenshot "([^"]*)"$/i */
    public function iTakeScreenShot($fileName = null)
    {
        $this->takeAScreenShot($fileName);
    }

    /** @When I navigate from a desktop browser */
    public function iNavigateFromADesktopBrowser()
    {
        if ($this->supportsJavaScript()) {
            $this->getSession()->resizeWindow(1024, 768);
        }
    }

    /** @When I navigate from a mobile device */
    public function iNavigateFromAMobileDevice()
    {
        if ($this->supportsJavaScript()) {
            $this->getSession()->resizeWindow(360, 480);
        }
    }

    /** @When I navigate from a tablet device */
    public function iNavigateFromATabledDevice()
    {
        if ($this->supportsJavaScript()) {
            $this->getSession()->resizeWindow(768, 1024);
        }
    }

    /**
     * @When /^I scroll to "([^"]*)"$/
     */
    public function iScrollTo($text)
    {
        $text = str_replace('\\"', '"', $text);
        $page = $this->getSession()->getPage();

        $element = $page->find('named', ['content', $text]);
        if (null === $element) {
            $element = $page->find('xpath', sprintf('//*[@value="%s"]', $text));
        }

        // DOES NOT WORK: $element->focus()

        // DO WORK:
        $selector =$element->getXpath();
        $function = <<<JS
            (function() {
              var elem = document.evaluate('$selector', document, null, XPathResult.FIRST_ORDERED_NODE_TYPE, null).singleNodeValue;
              elem.scrollIntoView();
            })()
JS;
        $this->getSession()->executeScript($function);
    }
}
