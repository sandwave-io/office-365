<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Library\Observer\Contact;

use SandwaveIo\Office365\Entity\CloudAgreementContact;

interface ContactObserverInterface
{
    public function execute(CloudAgreementContact $cloudAgreementContact): void;
}
