<?php

namespace Ssch\SwiftmailerSingleRecipient\Tests\Unit\Configuration;

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

use Nimut\TestingFramework\TestCase\UnitTestCase;
use Ssch\SwiftmailerSingleRecipient\Configuration\SingleRecipientConfigurationFactory;

/**
 * @covers \Ssch\SwiftmailerSingleRecipient\Configuration\SingleRecipientConfigurationFactory
 */
class SingleRecipientConfigurationFactoryTest extends UnitTestCase
{

    /**
     * @test
     */
    public function isValidConfiguration()
    {
        $configurationFactory = new SingleRecipientConfigurationFactory(['single_recipient' => 'valid@email.com']);
        $configuration = $configurationFactory->getConfiguration();
        $this->assertTrue($configuration->isValid());
    }

    /**
     * @test
     */
    public function isInvalidConfigurationDueToInvalidEmail()
    {
        $configurationFactory = new SingleRecipientConfigurationFactory(['single_recipient' => 'not valid']);
        $configuration = $configurationFactory->getConfiguration();
        $this->assertFalse($configuration->isValid());
    }

    /**
     * @test
     */
    public function isValidConfigurationViaGlobals()
    {
        $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['swiftmailer_single_recipient'] = serialize([
            'single_recipient' => 'dummy@domain.com',
        ]);
        $configurationFactory = new SingleRecipientConfigurationFactory();
        $configuration = $configurationFactory->getConfiguration();
        $this->assertTrue($configuration->isValid());
    }

    /**
     * @test
     */
    public function isInValidConfigurationViaGlobals()
    {
        $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['swiftmailer_single_recipient'] = serialize([
            'single_recipient' => '',
        ]);
        $configurationFactory = new SingleRecipientConfigurationFactory();
        $configuration = $configurationFactory->getConfiguration();
        $this->assertFalse($configuration->isValid());
    }

    /**
     * @test
     */
    public function emptyConfigurationIsInValid()
    {
        $configurationFactory = new SingleRecipientConfigurationFactory();
        $configuration = $configurationFactory->getConfiguration();
        $this->assertFalse($configuration->isValid());
    }

    /**
     * @test
     */
    public function isInvalidConfigurationDueToEmptySingleRecipient()
    {
        $configurationFactory = new SingleRecipientConfigurationFactory([]);
        $configuration = $configurationFactory->getConfiguration();
        $this->assertFalse($configuration->isValid());
    }
}
