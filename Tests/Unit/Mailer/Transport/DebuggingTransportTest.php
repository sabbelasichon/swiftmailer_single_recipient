<?php

namespace Ssch\SwiftmailerSingleRecipient\Tests\Unit\Mailer\Transport;

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
use Ssch\SwiftmailerSingleRecipient\Mailer\Transport\DebuggingTransport;
use Swift_Mime_Message;

class DebuggingTransportTest extends UnitTestCase
{

    /**
     * @var DebuggingTransport
     */
    private $subject;


    protected function setUp()
    {
        $this->subject = new DebuggingTransport();
    }


    /**
     * @test
     */
    public function sendMailsReturnsCorrectCount()
    {
        $message = $this->getMock(Swift_Mime_Message::class);
        $message->method('getBcc')->willReturn('dummy@domain.com');
        $message->method('getCc')->willReturn('dummy@domain.com');
        $message->method('getTo')->willReturn('dummy@domain.com');
        $this->assertEquals(3, $this->subject->send($message));
    }


    /**
     * @test
     */
    public function correctRecipientsAreReturnedAfterSending()
    {
        $firstMessage = $this->getMock(Swift_Mime_Message::class);
        $firstMessage->method('getTo')->willReturn('dummy@domain.com');
        $this->subject->send($firstMessage);

        $secondMessage = $this->getMock(Swift_Mime_Message::class);
        $secondMessage->method('getTo')->willReturn('another@domain.com');
        $this->subject->send($secondMessage);

        $this->assertEquals([$firstMessage, $secondMessage], DebuggingTransport::getDeliveredMessages());
    }


    protected function tearDown()
    {
        DebuggingTransport::reset();
    }

}
