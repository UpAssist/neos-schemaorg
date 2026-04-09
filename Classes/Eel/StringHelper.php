<?php
namespace UpAssist\Neos\SchemaOrg\Eel;

use Neos\Flow\Annotations as Flow;
use Neos\Eel\ProtectedContextAwareInterface;

/**
 * @Flow\Scope("singleton")
 */
class StringHelper implements ProtectedContextAwareInterface
{
    public function htmlEntityDecode(string $string): string
    {
        return html_entity_decode($string, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    }

    public function allowsCallOfMethod($methodName): bool
    {
        return true;
    }
}
