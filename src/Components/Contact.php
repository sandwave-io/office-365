<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Components;

use SandwaveIo\Office365\Components\Contact\Agreement;

final class Contact
{
    public Agreement $agreement;

    public function __construct(Agreement $agreement)
    {
        $this->agreement = $agreement;
    }
}
