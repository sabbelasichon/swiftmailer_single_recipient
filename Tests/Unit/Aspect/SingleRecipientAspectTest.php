<?php

namespace Ssch\SwiftmailerSingleRecipient\Tests\Unit\Aspect;

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
use Ssch\SwiftmailerSingleRecipient\Aspect\SingleRecipientAspect;
use Ssch\SwiftmailerSingleRecipient\Configuration\SingleRecipientConfigurationFactory;
use TYPO3\CMS\Core\Mail\Mailer;

class SingleRecipientAspectTest extends UnitTestCase
{

    /**
     * @test
     */
    public function registerPluginIsCalled()
    {
        $mailer = $this->getMockBuilder(Mailer::class)->disableOriginalConstructor()->getMock();
        $mailer->expects($this->once())->method('registerPlugin');

        $configurationFactory = new SingleRecipientConfigurationFactory(['single_recipient' => 'valid@email.com']);
        $subject = new SingleRecipientAspect($configurationFactory);

        $subject->handle($mailer);
    }

    /**
     * @test
     */
    public function registerPluginIsNotCalled()
    {
        $mailer = $this->getMockBuilder(Mailer::class)->disableOriginalConstructor()->getMock();
        $mailer->expects($this->never())->method('registerPlugin');

        $configurationFactory = new SingleRecipientConfigurationFactory([]);
        $subject = new SingleRecipientAspect($configurationFactory);

        $subject->handle($mailer);
    }
}
