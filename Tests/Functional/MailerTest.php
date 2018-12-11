<?php
declare(strict_types=1);


namespace Ssch\SwiftmailerSingleRecipient\Tests\Functional;

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

use Nimut\TestingFramework\TestCase\FunctionalTestCase;
use Ssch\SwiftmailerSingleRecipient\Mailer\Transport\DebuggingTransport;
use TYPO3\CMS\Core\Mail\Mailer;
use TYPO3\CMS\Core\Utility\GeneralUtility;

final class MailerTest extends FunctionalTestCase
{

    protected $testExtensionsToLoad = ['typo3conf/ext/swiftmailer_single_recipient'];

    private $mailer;

    protected function setUp()
    {
        $GLOBALS['TYPO3_CONF_VARS']['MAIL']['transport'] = DebuggingTransport::class;
        $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['swiftmailer_single_recipient'] = serialize([
            'single_recipient' => 'dummy@domain.com',
        ]);
        parent::setUp();


        $this->mailer = GeneralUtility::makeInstance(Mailer::class);
    }

    /**
     * @test
     */
    public function sendMailToSingleRecipient()
    {
        $message = new \Swift_Message('Test message');
        $message->setTo('real@email.com');
        $this->mailer->send($message);

        $sendMessages = DebuggingTransport::getDeliveredMessages();
        foreach ($sendMessages as $sendMessage) {
            $this->assertEquals('dummy@domain.com', $sendMessage->getTo());
            $this->assertEquals('real@email.com', $sendMessage->getHeaders()->get('X-Swift-To'));
        }
    }


    protected function tearDown()
    {
        DebuggingTransport::reset();
    }
}
