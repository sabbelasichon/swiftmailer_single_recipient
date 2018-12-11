<?php
declare(strict_types=1);

namespace Ssch\SwiftmailerSingleRecipient\Mailer\Transport;

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

use Swift_Events_EventListener;
use Swift_Mime_Message;

final class DebuggingTransport implements \Swift_Transport
{

    /**
     * Store sent messages for testing
     *
     * @var \Swift_Message[]
     */
    private static $deliveredMessages = [];

    /**
     * Test if this Transport mechanism has started.
     *
     * @return bool
     */
    public function isStarted(): bool
    {
        return true;
    }

    /**
     * Start this Transport mechanism.
     */
    public function start()
    {
    }

    /**
     * Stop this Transport mechanism.
     */
    public function stop()
    {
    }

    /**
     * Send the given Message.
     *
     * Recipient/sender data will be retrieved from the Message API.
     * The return value is the number of recipients who were accepted for delivery.
     *
     * @param Swift_Mime_Message $message
     * @param string[] $failedRecipients An array of failures by-reference
     *
     * @return int
     */
    public function send(Swift_Mime_Message $message, &$failedRecipients = null): int
    {
        self::$deliveredMessages[] = $message;

        return \count((array)$message->getTo()) + \count((array)$message->getCc()) + \count((array)$message->getBcc());
    }

    /**
     * Get delivered messages that were sent through this transport
     *
     * @return \Swift_Message[]
     */
    public static function getDeliveredMessages(): array
    {
        return self::$deliveredMessages;
    }

    /**
     * Reset the status
     */
    public static function reset()
    {
        self::$deliveredMessages = [];
    }

    /**
     * Register a plugin in the Transport.
     *
     * @param Swift_Events_EventListener $plugin
     */
    public function registerPlugin(Swift_Events_EventListener $plugin)
    {
    }
}
