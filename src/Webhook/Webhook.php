<?php declare(strict_types=1);

namespace Office365\Webhook;

use Office365\Helper\EntityHelper;
use Office365\Observer\Subjects;
use Office365\Transformer\ClassTransformer;
use Office365\Transformer\RootnodeTransformer;

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

    public function parse(string $xml)
    {
        $xml = simplexml_load_string($xml);

        $eventName = RootnodeTransformer::transform($xml->getName());
        $className = ClassTransformer::transform($xml->getName());

        $entity = EntityHelper::deserialize($className,  (array) $xml);
echo $entity->getName();exit;
        $subject = $this->subjects->getSubject($eventName, $entity);

        if ($subject !== null) {
            $subject->notify();
        }

        return $entity;
    }
}
