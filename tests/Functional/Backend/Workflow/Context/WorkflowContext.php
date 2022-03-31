<?php

declare(strict_types=1);

namespace App\Tests\Functional\Backend\Workflow\Context;

use App\Tests\Common\Context\UtilsRawContext;
use App\Tests\Common\Util\Spins;
use PHPUnit\Framework\Assert;

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

    /**
     * @Then I choose :value from :field
     */
    public function iChooseFrom($value, $field)
    {
        // Buscamos el item cuyo texto sea = $value
        $waitForOptionsToAppear = function () use ($value, $field) {
            $page = $this->getSession()->getPage();

            // Find the select.
            $label = $page->find('xpath', sprintf("//label[text()='%s']", $field));

            // Click para que los items sean visibles
            $editor = $label->getParent()->find('css', '.ts-control');
            $editor->click();

            $dropDownContent = $page->find('css', '.ts-dropdown-content');
            $items = $dropDownContent->findAll('css', '.option');

            // echo "Total items found: " . count($items) . PHP_EOL;
            if (count($items) === 0) {
                return false;
            }

            foreach ($items as $item) {
                // echo $item->getText() . PHP_EOL;
                if ($item->getText() === $value) {
                    $item->click();
                    return true;
                }
            }

            return false;
        };

        Spins::spins($waitForOptionsToAppear);
    }

    /**
     * @Then I should see :total row
     * @Then I should see :total rows
     */
    public function iShouldSeeRow($expected)
    {
        $actual = $this->getSession()->getPage()->find('css', '.datagrid tbody')
                       ->findAll('css', 'tr');

        Assert::assertEquals($expected, count($actual));
    }

    /**
     * @Then I should see :arg1 for the column :arg2 in the row :arg3
     */
    public function iShouldSeeForTheColumnInTheRow($value, $field, $index)
    {
        // Buscamos la fila del header
        $header = $this->getSession()->getPage()->find('css', '.datagrid thead tr');

        // Buscamos el índice de la columna con el texto $field
        $headerCols = $header->findAll('css', 'th');
dump($headerCols[1]->getHtml()); die();
        $col = 0;
        foreach ($headerCols as $headerCol) {
            $col++;
            echo $headerCol->getText() . PHP_EOL;
            if ($field === trim($headerCol->getText())) {
                // Ya tenemos el índice de la columa con el texto $field
                break;
            }
        }


        // Buscamos todas las filas de contenidos
        $contents = $this->getSession()->getPage()->find('css', '.datagrid tbody')
                         ->findAll('css', 'tr');

        // Nos quedamos con la fila número $index
        $row = $contents[$index-1];

        // Nos quedamos con todas las columnas
        $rowCols = $row->findAll('css', 'td');

        // Comprobamos que la fila-columna tiene el texto pasado en $value
        Assert::assertEquals($value, $rowCols[$col]->getText());
    }
}
