<?php

namespace Ssch\SwiftmailerSingleRecipient\Tests\Unit\Mailer;

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
use Ssch\SwiftmailerSingleRecipient\Configuration\SingleRecipientConfiguration;
use Ssch\SwiftmailerSingleRecipient\Configuration\SingleRecipientConfigurationFactory;
use Ssch\SwiftmailerSingleRecipient\Mailer\Plugins\NullPlugin;
use Ssch\SwiftmailerSingleRecipient\Mailer\SingleRecipientPluginFactory;

/**
 * @covers \Ssch\SwiftmailerSingleRecipient\Mailer\SingleRecipientPluginFactory
 */
class SingleRecipientPluginFactoryTest extends UnitTestCase
{
    /**
     * @var SingleRecipientPluginFactory
     */
    protected $subject;

    /**
     * @var SingleRecipientConfiguration
     */
    private $configuration;

    protected function setUp()
    {
        $this->configuration = $this->prophesize(SingleRecipientConfiguration::class);
        $singleRecipientConfigurationFactory = $this->prophesize(SingleRecipientConfigurationFactory::class);
        $singleRecipientConfigurationFactory->getConfiguration()->willReturn($this->configuration);
        $this->subject = new SingleRecipientPluginFactory($singleRecipientConfigurationFactory->reveal());
    }

    /**
     * @test
     */
    public function returnsNullPluginDueToInvalidConfiguration()
    {
        $this->configuration->isValid()->willReturn(false);
        $this->assertInstanceOf(NullPlugin::class, $this->subject->getPlugin());
    }

    /**
     * @test
     */
    public function returnsSwiftPluginsRedirectingPlugin()
    {
        $this->configuration->isValid()->willReturn(true);
        $this->configuration->getSingleRecipients()->willReturn([]);
        $this->configuration->getWhitelist()->willReturn([]);
        $this->assertInstanceOf(\Swift_Plugins_RedirectingPlugin::class, $this->subject->getPlugin());
    }
}
