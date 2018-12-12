<?php
declare(strict_types = 1);

namespace Ssch\SwiftmailerSingleRecipient\Mailer\Plugins;

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

use Swift_Events_SendEvent;
use Swift_Events_SendListener;

final class NullPlugin implements Swift_Events_SendListener
{
    public function beforeSendPerformed(Swift_Events_SendEvent $evt)
    {
    }

    public function sendPerformed(Swift_Events_SendEvent $evt)
    {
    }
}
