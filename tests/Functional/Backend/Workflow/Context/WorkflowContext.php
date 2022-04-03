<?php

declare(strict_types=1);

namespace App\Tests\Functional\Backend\Workflow\Context;

use App\Repository\Product\ProductQuery;
use App\Tests\Common\Context\UtilsRawContext;
use App\Tests\Common\Util\Spins;
use Behat\MinkExtension\Context\RawMinkContext;
use PHPUnit\Framework\Assert;

# HEREDAR DE UtilsRawContext, Para poder tomar pantallazos, problema de herencia, mejor inyectar  => final class WorkflowContext extends UtilsRawContext
final class WorkflowContext extends RawMinkContext
{
    private UtilsRawContext $utilsRawContext;
    private ProductQuery    $productQuery;

    public function __construct(UtilsRawContext $utilsRawContext, ProductQuery $productQuery)
    {
        $this->utilsRawContext = $utilsRawContext;
        $this->productQuery = $productQuery;
    }

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
        // 1.1 Buscamos la fila del header
        $header = $this->getSession()->getPage()->find('css', '.datagrid thead tr');

        // 1.2 Buscamos el índice de la columna con el texto $field
        $headerCols = $header->findAll('css', 'th');

        // 2. También Podemos encontrarlo directamente así:
        $headerCols = $this->getSession()->getPage()->findAll('css', '.datagrid thead tr th a');

        $col = 0;
        foreach ($headerCols as $headerCol) {
            $col++;
            $parsedField = trim(strip_tags($headerCol->getHtml()));
            if ($field === $parsedField) {
                // Ya tenemos el índice de la columa con el texto $field
                break;
            }
        }


        // Buscamos todas las filas de contenidos
        $contents = $this->getSession()->getPage()->findAll('css', '.datagrid tbody tr');

        // Nos quedamos con la fila número $index
        $row = $contents[$index-1];

        // Nos quedamos con todas las columnas
        $rowCols = $row->findAll('css', 'td');

        // Comprobamos que la fila-columna tiene el texto pasado en $value
        Assert::assertEquals($value, $rowCols[$col]->getText());
    }
    /**
     * @Then I enable product
     */
    public function iEnableProduct()
    {
        $this->getSession()->getPage()->findById('ProductEntity_enabled')->click();
    }

    /**
     * @Then Product should be saved properly into database
     */
    public function productShouldBeSavedProperlyIntoDatabase()
    {
        $productEntity = $this->productQuery->findLastInsertedProduct();
        Assert::assertNotNull($productEntity);

        Assert::assertEquals($productEntity->getName(), 'The Delta force');
        Assert::assertEquals($productEntity->getDescription(), '<div>A film about terrorists and airplane hijacking</div>');
        Assert::assertEquals($productEntity->getEnabled(), true);
        Assert::assertEquals($productEntity->getPrice(), 55);
    }

    /**
     * @Then I should see the field :field with the value :value
     */
    public function iShouldSeeTheFieldWithTheValue($field, $value)
    {
        $node = $this->getSession()->getPage()->find('named', ['content', $field]);
        $actual = $node->getParent()->findAll('css', 'td')[1]->getText();
        Assert::assertEquals($value, $actual);
    }
}
