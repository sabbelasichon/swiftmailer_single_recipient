<?php
declare(strict_types=1);

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

namespace Ssch\SwiftmailerSingleRecipient\Configuration;

use Ssch\SwiftmailerSingleRecipient\ValueObject\EmailAddress;
use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;

final class SingleRecipientConfigurationFactory implements SingletonInterface
{
    private $configuration;

    private $extensionConfiguration;

    public function __construct(array $extensionConfiguration = null)
    {
        $this->extensionConfiguration = $extensionConfiguration ?? unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['swiftmailer_single_recipient']);
    }

    public function getConfiguration(): SingleRecipientConfiguration
    {
        if ($this->configuration === null) {
            $singleRecipients = [];

            if (isset($this->extensionConfiguration['single_recipient'])) {
                try {
                    $singleRecipients = $this->transformListToEmailAddressArray($this->extensionConfiguration['single_recipient']);
                } catch (\InvalidArgumentException $e) {
                }
            }

            $whitelist = [];

            if (isset($this->extensionConfiguration['whitelist'])) {
                try {
                    $whitelist = $this->transformListToEmailAddressArray($this->extensionConfiguration['whitelist']);
                } catch (\InvalidArgumentException $e) {
                }
            }

            $this->configuration = new SingleRecipientConfiguration($singleRecipients, $whitelist);
        }

        return $this->configuration;
    }

    private function transformListToEmailAddressArray(string $listOfEmails): array
    {
        return array_map(function ($email) {
            return new EmailAddress($email);
        }, GeneralUtility::trimExplode(',', $listOfEmails));
    }
}
