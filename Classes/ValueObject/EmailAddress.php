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

namespace Ssch\SwiftmailerSingleRecipient\ValueObject;

use InvalidArgumentException;

final class EmailAddress
{
    /**
     * @var string
     */
    private $email;

    public function __construct(string $email)
    {
        if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('Invalid email address');
        }

        $this->email = $email;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function __toString(): string
    {
        return $this->email;
    }
}
