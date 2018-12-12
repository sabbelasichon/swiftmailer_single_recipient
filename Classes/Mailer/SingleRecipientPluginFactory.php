<?php
declare(strict_types = 1);

namespace Ssch\SwiftmailerSingleRecipient\Mailer;

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

use Ssch\SwiftmailerSingleRecipient\Configuration\SingleRecipientConfigurationFactory;
use Ssch\SwiftmailerSingleRecipient\Mailer\Plugins\NullPlugin;
use Swift_Events_SendListener;
use Swift_Plugins_RedirectingPlugin;

final class SingleRecipientPluginFactory
{
    private $configuration;

    public function __construct(SingleRecipientConfigurationFactory $factory)
    {
        $this->configuration = $factory->getConfiguration();
    }

    public function getPlugin(): Swift_Events_SendListener
    {
        if ($this->configuration->isValid()) {
            return new Swift_Plugins_RedirectingPlugin($this->configuration->getSingleRecipients(), $this->configuration->getWhitelist());
        }

        return new NullPlugin();
    }
}
