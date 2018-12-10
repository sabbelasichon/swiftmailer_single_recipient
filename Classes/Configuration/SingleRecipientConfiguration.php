<?php
declare(strict_types = 1);

namespace Ssch\SwiftmailerSingleRecipient\Configuration;

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

use Ssch\SwiftmailerSingleRecipient\ValueObject\EmailAddress;
use Webmozart\Assert\Assert;

final class SingleRecipientConfiguration
{
    private $singleRecipients;

    private $whitelist;

    /**
     * SingleRecipientConfiguration constructor.
     *
     * @param EmailAddress[] $singleRecipients
     * @param EmailAddress[] $whitelist
     */
    public function __construct(array $singleRecipients = [], array $whitelist = [])
    {
        Assert::allIsInstanceOf($singleRecipients, EmailAddress::class);
        Assert::allIsInstanceOf($whitelist, EmailAddress::class);
        $this->singleRecipients = $singleRecipients;
        $this->whitelist = $whitelist;
    }

    public function isValid(): bool
    {
        return \count($this->singleRecipients) > 0;
    }

    public function getSingleRecipients(): array
    {
        return $this->singleRecipients;
    }

    public function getWhitelist(): array
    {
        return $this->whitelist;
    }
}
