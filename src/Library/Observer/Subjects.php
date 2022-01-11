<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Library\Observer;

use SandwaveIo\Office365\Entity\Customer;
use SandwaveIo\Office365\Entity\EntityInterface;
use SandwaveIo\Office365\Enum\Event;
use SandwaveIo\Office365\Library\Observer\Customer\CustomerObserver;
use SandwaveIo\Office365\Library\Observer\Customer\CustomerObserverInterface;
use SandwaveIo\Office365\Library\Observer\Customer\CustomerSubject;
use SplSubject;

final class Subjects
{
    /** @var array<string, SplSubject> */
    private array $subject = [];

    public function attach(string $event, $callback): void
    {
        switch ($event) {
            case Event::CUSTOMER_CREATE:
                $observer = new CustomerObserver($callback);
                $subject = new CustomerSubject();
                break;
            default:
                return;
        }

        if (!array_key_exists($event, $this->subject)) {
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
                    if (!is_subclass_of($entity, Customer::class)) {
                        return null;
                    }
                    $subject->setCustomer($entity);
                    break;
            }

            return $this->subject[$event];
        }

        return null;
    }
}
