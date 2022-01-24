<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Library\Observer;

use SandwaveIo\Office365\Entity\CloudLicense;
use SandwaveIo\Office365\Entity\Customer;
use SandwaveIo\Office365\Entity\EntityInterface;
use SandwaveIo\Office365\Entity\OrderModifyQuantity;
use SandwaveIo\Office365\Enum\Event;
use SandwaveIo\Office365\Library\Observer\CloudLicense\CloudLicenseObserver;
use SandwaveIo\Office365\Library\Observer\CloudLicense\CloudLicenseSubject;
use SandwaveIo\Office365\Library\Observer\Order\OrderModifyQuantitySubject;
use SandwaveIo\Office365\Library\Observer\Customer\CustomerObserver;
use SandwaveIo\Office365\Library\Observer\Customer\CustomerSubject;
use SandwaveIo\Office365\Library\Observer\Order\OrderModifyQuantityObserver;
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

            case Event::ORDER_MODIFY_QUANTITY:
                $observer = new OrderModifyQuantityObserver($callback);
                $subject = new OrderModifyQuantitySubject();
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

                case Event::ORDER_MODIFY_QUANTITY:
                    /** @var OrderModifyQuantity $subject */
                    if (! $entity instanceof OrderModifyQuantity) {
                        return null;
                    }

                    /** @var OrderModifyQuantity $subject */
                    $subject->setOrderModifyQuantity($entity);
                    break;
            }

            return $this->subject[$event];
        }

        return null;
    }
}
