<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Webhook;

use SandwaveIo\Office365\Entity\EntityInterface;
use SandwaveIo\Office365\Exception\Office365Exception;
use SandwaveIo\Office365\Helper\EntityHelper;
use SandwaveIo\Office365\Library\Observer\Subjects;
use SandwaveIo\Office365\Transformer\RootnodeTransformer;

/**
 * Class Webhook
 * @package SandwaveIo\Office365\Webhook
 * @deprecated This should go into the implementer.
 */
class Webhook
{
    private Subjects $subjects;

    public function __construct(Subjects $subjects)
    {
        $this->subjects = $subjects;
    }

    public function addEventSubscriber(string $type, $callback): void
    {
        $this->subjects->attach($type, $callback);
    }

    /**
     * @throws Office365Exception
     */
    public function dispatch(string $xml): EntityInterface
    {
        $xmlObject = simplexml_load_string($xml);

        if ($xmlObject === false) {
            throw new Office365Exception(self::class . '::dispatch - unable to load XML from supplied string.');
        }

        $entity = EntityHelper::createFromXML($xml);
        $eventName = RootnodeTransformer::transform($xmlObject->getName());
        $subject = $this->subjects->getSubject($eventName, $entity);

        if ($subject !== null) {
            $subject->notify();
        }

        return $entity;
    }
}
