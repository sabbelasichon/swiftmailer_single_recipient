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
use Ssch\SwiftmailerSingleRecipient\Configuration\SingleRecipientConfiguration;
use Ssch\SwiftmailerSingleRecipient\ValueObject\EmailAddress;

class SingleRecipientConfigurationTest extends UnitTestCase
{

    /**
     * @test
     */
    public function emailAddressIsEqual()
    {
        $configuration = new SingleRecipientConfiguration([new EmailAddress('valid@email.com')]);
        $this->assertCount(1, $configuration->getSingleRecipients());
    }

    /**
     * @test
     */
    public function emailAddressIsNull()
    {
        $configuration = new SingleRecipientConfiguration();
        $this->assertEmpty($configuration->getSingleRecipients());
    }

    /**
     * @test
     */
    public function whitelistContainsWrongTypeThrowsException()
    {
        $this->expectException(\InvalidArgumentException::class);
        new SingleRecipientConfiguration([], ['string', 'something']);
    }

    /**
     * @test
     */
    public function whitelistContainsCorrectTypes()
    {
        $configuration = new SingleRecipientConfiguration([], [new EmailAddress('valid@email.com'), new EmailAddress('valid@email.com')]);
        $this->assertCount(2, $configuration->getWhitelist());
    }
}
