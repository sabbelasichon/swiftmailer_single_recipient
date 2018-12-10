<?php

namespace Ssch\SwiftmailerSingleRecipient\Tests\Unit\ValueObject;

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
use Ssch\SwiftmailerSingleRecipient\ValueObject\EmailAddress;

class EmailAddressTest extends UnitTestCase
{

    /**
     * @test
     */
    public function noValidateEmailThrowsException()
    {
        $this->expectException(\InvalidArgumentException::class);
        new EmailAddress('notavalidemailaddress');
    }

    /**
     * @test
     */
    public function validateEmailAddressIsAssigned()
    {
        $emailAddress = new EmailAddress('valid@email.com');
        $this->assertEquals('valid@email.com', $emailAddress);
    }
}
