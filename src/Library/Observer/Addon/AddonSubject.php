<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Library\Observer\Addon;

use SandwaveIo\Office365\Entity\Addon;
use SandwaveIo\Office365\Library\Observer\Subject\AbstractSubject;

final class AddonSubject extends AbstractSubject
{
    private Addon $addon;

    public function setAddon(Addon $addon): void
    {
        $this->addon = $addon;
    }

    public function getAddon(): Addon
    {
        return $this->addon;
    }
}
