<?php
declare(strict_types=1);

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

use Ssch\SwiftmailerSingleRecipient\Configuration\SingleRecipientConfigurationFactory;
use TYPO3\CMS\Core\Mail\Mailer;

final class SingleRecipientAspect
{
    private $configuration;

    public function __construct(SingleRecipientConfigurationFactory $factory)
    {
        $this->configuration = $factory->getConfiguration();
    }

    public function handle(Mailer $mailer)
    {
        if ($this->configuration->isValid()) {
            $mailer->registerPlugin(new \Swift_Plugins_RedirectingPlugin($this->configuration->getSingleRecipients(), $this->configuration->getWhitelist()));
        }
    }
}
