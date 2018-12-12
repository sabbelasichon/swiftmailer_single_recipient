<?php
declare(strict_types = 1);

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

use Swift_DependencyContainer;
use Swift_Events_EventListener;
use Swift_Events_SendEvent;
use Swift_Mime_Message;

final class DebuggingTransport implements \Swift_Transport
{

    /**
     * Store sent messages for testing
     *
     * @var \Swift_Message[]|\Swift_Mime_Message[]
     */
    private static $deliveredMessages = [];

    private $eventDispatcher;

    private $options;

    public function __construct(array $options = [])
    {
        $this->options = $options;
        $this->eventDispatcher = Swift_DependencyContainer::getInstance()->lookup('transport.eventdispatcher');
    }

    public function isStarted(): bool
    {
        return true;
    }

    public function start()
    {
    }

    public function stop()
    {
    }

    public function send(Swift_Mime_Message $message, &$failedRecipients = null): int
    {
        $evt = $this->eventDispatcher->createSendEvent($this, $message);

        if ($evt instanceof Swift_Events_SendEvent) {
            $this->eventDispatcher->dispatchEvent($evt, 'beforeSendPerformed');
            if ($evt->bubbleCancelled()) {
                return 0;
            }
        }

        self::$deliveredMessages[] = clone $message;

        if ($evt instanceof Swift_Events_SendEvent) {
            $evt->setResult(Swift_Events_SendEvent::RESULT_SUCCESS);
            $this->eventDispatcher->dispatchEvent($evt, 'sendPerformed');
        }

        return \count((array)$message->getTo()) + \count((array)$message->getCc()) + \count((array)$message->getBcc());
    }

    public static function getDeliveredMessages(): array
    {
        return self::$deliveredMessages;
    }

    public static function reset()
    {
        self::$deliveredMessages = [];
    }

    public function getOptions(): array
    {
        return $this->options;
    }

    public function registerPlugin(Swift_Events_EventListener $plugin)
    {
        $this->eventDispatcher->bindEventListener($plugin);
    }
}
