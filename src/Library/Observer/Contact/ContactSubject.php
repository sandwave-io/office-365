<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Library\Observer\Contact;

use SandwaveIo\Office365\Entity\CloudAgreementContact;
use SplObserver;

final class ContactSubject implements \SplSubject
{
    private \SplObjectStorage $observers;

    private CloudAgreementContact $cloudAgreementContact;

    public function __construct()
    {
        $this->observers = new \SplObjectStorage();
    }

    public function attach(SplObserver $observer): void
    {
        $this->observers->attach($observer);
    }

    public function detach(SplObserver $observer): void
    {
        $this->observers->detach($observer);
    }

    public function notify(): void
    {
        foreach ($this->observers as $observer) {
            /** @var SplObserver $observer */
            $observer->update($this);
        }
    }

    public function setContact(CloudAgreementContact $cloudAgreementContact): void
    {
        $this->cloudAgreementContact = $cloudAgreementContact;
    }

    public function getContact(): CloudAgreementContact
    {
        return $this->cloudAgreementContact;
    }
}
