<?php

declare(strict_types=1);

namespace App\Tests\Functional\Backend\Workflow\Context;

use App\Tests\Functional\Backend\Workflow\DataFixtures\DataFixturesInitializer;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Behat\MinkExtension\Context\RawMinkContext;

final class InitializationContext extends RawMinkContext
{
    private DataFixturesInitializer $dataFixturesInitializer;

    public function __construct(DataFixturesInitializer $dataFixturesInitializer)
    {
        $this->dataFixturesInitializer = $dataFixturesInitializer;
    }

    /** @BeforeScenario */
    public function beforeScenario(BeforeScenarioScope $event)
    {
        if (in_array('IGNORE_DATA_FIXTURES', $event->getScenario()->getTags())) {
            return;
        }

        $this->dataFixturesInitializer->initialize();
    }
}
