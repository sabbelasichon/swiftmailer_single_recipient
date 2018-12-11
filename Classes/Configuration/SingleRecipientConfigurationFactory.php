<?php
declare(strict_types = 1);

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
        if (! $this->configuration instanceof SingleRecipientConfiguration) {
            $this->configuration = new SingleRecipientConfiguration(
                $this->transformListToEmailAddressArrayIfKeyExists('single_recipient'),
                $this->transformListToEmailAddressArrayIfKeyExists('whitelist')
            );
        }

        return $this->configuration;
    }

    private function transformListToEmailAddressArrayIfKeyExists(string $key): array
    {
        if (array_key_exists($key, $this->extensionConfiguration) && $this->extensionConfiguration[$key] !== '') {
            try {
                return array_map(function ($email) {
                    return new EmailAddress($email);
                }, GeneralUtility::trimExplode(',', $this->extensionConfiguration[$key]));
            } catch (\InvalidArgumentException $e) {
            }
        }

        return [];
    }
}
