<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Library\Observer;

use SandwaveIo\Office365\Entity\Addon;
use SandwaveIo\Office365\Entity\CloudAgreementContact;
use SandwaveIo\Office365\Entity\CloudLicense;
use SandwaveIo\Office365\Entity\Customer;
use SandwaveIo\Office365\Entity\EntityInterface;
use SandwaveIo\Office365\Entity\Terminate;
use SandwaveIo\Office365\Enum\Event;
use SandwaveIo\Office365\Library\Observer\Addon\AddonObserver;
use SandwaveIo\Office365\Library\Observer\Addon\AddonSubject;
use SandwaveIo\Office365\Library\Observer\CloudLicense\CloudLicenseObserver;
use SandwaveIo\Office365\Library\Observer\CloudLicense\CloudLicenseSubject;
use SandwaveIo\Office365\Library\Observer\Contact\ContactObserver;
use SandwaveIo\Office365\Library\Observer\Contact\ContactSubject;
use SandwaveIo\Office365\Library\Observer\Customer\CustomerObserver;
use SandwaveIo\Office365\Library\Observer\Customer\CustomerSubject;
use SandwaveIo\Office365\Library\Observer\Terminate\TerminateObserver;
use SandwaveIo\Office365\Library\Observer\Terminate\TerminateSubject;
use SplSubject;

final class Subjects
{
    /** @var array<string, SplSubject> */
    private array $subject = [];

    /** @param mixed $callback */
    public function attach(string $event, $callback): void
    {
        switch ($event) {
            case Event::CUSTOMER_CREATE:
                $observer = new CustomerObserver($callback);
                $subject = new CustomerSubject();
                break;

            case Event::CLOUD_LICENSE_ORDER_CREATE:
                $observer = new CloudLicenseObserver($callback);
                $subject = new CloudLicenseSubject();
                break;

            case Event::CLOUD_AGREEMENT_CREATE:
                $observer = new ContactObserver($callback);
                $subject = new ContactSubject();
                break;

            case Event::CLOUD_LICENSE_ADDON_CREATE:
                $observer = new AddonObserver($callback);
                $subject = new AddonSubject();
                break;

            case Event::TERMINATE_ORDER:
                $observer = new TerminateObserver($callback);
                $subject = new TerminateSubject();
                break;
            default:
                return;
        }

        if (! array_key_exists($event, $this->subject)) {
            $this->subject[$event] = $subject;
        }

        $this->subject[$event]->attach($observer);
    }

    public function getSubject(string $event, EntityInterface $entity): ?SplSubject
    {
        if (array_key_exists($event, $this->subject)) {
            $subject = $this->subject[$event];

            switch ($event) {
                case Event::CUSTOMER_CREATE:
                    /** @var CustomerSubject $subject */
                    if (! $entity instanceof Customer) {
                        return null;
                    }
                    $subject->setCustomer($entity);
                    break;

                case Event::CLOUD_LICENSE_ORDER_CREATE:
                    /** @var CloudLicense $subject */
                    if (! $entity instanceof CloudLicense) {
                        return null;
                    }

                    /** @var CloudLicenseSubject $subject */
                    $subject->setCloudLicense($entity);
                    break;

                case Event::CLOUD_AGREEMENT_CREATE:
                    /** @var ContactSubject $subject */
                    if (! $entity instanceof CloudAgreementContact) {
                        return null;
                    }
                    $subject->setContact($entity);
                    break;

                case Event::CLOUD_LICENSE_ADDON_CREATE:
                    /** @var AddonSubject $subject */
                    if (! $entity instanceof Addon) {
                        return null;
                    }
                    $subject->setAddon($entity);

                    // no break
                case Event::TERMINATE_ORDER:
                    /** @var TerminateSubject $subject */
                    if (! $entity instanceof Terminate) {
                        return null;
                    }
                    $subject->setTerminate($entity);
            }

            return $this->subject[$event];
        }

        return null;
    }
}
