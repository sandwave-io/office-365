<?php declare(strict_types = 1);

namespace SandwaveIo\Office365\Transformer;

final class CustomerResponseXmlTransformer implements TransformerInterface
{
    public function transform(string $xml): string
    {
        $doc = new \DOMDocument('1.0');
        $doc->preserveWhiteSpace = false;
        $doc->formatOutput = true;
        $doc->loadXML($xml);

        $xpath = new \DOMXPath($doc);
        $properties = $xpath->query('//CustomerData/*');

        if (is_iterable($properties)) {
            foreach ($properties as $property) {
                $node = $doc->importNode($property, true);
                $doc->documentElement->appendChild($node);
            }
        }

        $date = new \DateTime((string) $doc->getElementsByTagName('DateCreated')->item(0)->nodeValue);
        $doc->getElementsByTagName('DateCreated')->item(0)->nodeValue = $date->format('Y-m-d\TH:i:s');

        return $doc->saveXML();
    }
}
