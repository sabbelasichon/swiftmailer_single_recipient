<?php
declare(strict_types = 1);

namespace Ssch\SwiftmailerSingleRecipient\Aspect;

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

use Ssch\SwiftmailerSingleRecipient\Mailer\SingleRecipientPluginFactory;
use TYPO3\CMS\Core\Mail\Mailer;

final class SingleRecipientAspect
{
    /**
     * @var \Swift_Events_SendListener
     */
    private $plugin;

    public function __construct(SingleRecipientPluginFactory $singleRecipientPluginFactory)
    {
        $this->plugin = $singleRecipientPluginFactory->getPlugin();
    }

    public function handle(Mailer $mailer)
    {
        $mailer->registerPlugin($this->plugin);
    }
}
