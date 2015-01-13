<?php

namespace Psecio\Parse\Rule;

use Psecio\Parse\RuleInterface;
use PhpParser\Node;
use PhpParser\Node\Expr\FuncCall;

/**
 * The ereg functions have been deprecated as of PHP 5.3.0. Don't use them!
 */
class EregFunctions implements RuleInterface
{
    use Helper\NameTrait;

    private $functions = ['ereg', 'eregi', 'ereg_replace', 'eregi_replace'];

    public function getDescription()
    {
        return 'Remove any use of ereg functions, deprecated and removed. Use preg_*';
    }

    public function isValid(Node $node)
    {
        $nodeName = (is_object($node->name)) ? $node->name->parts[0] : $node->name;

        if ($node instanceof FuncCall && in_array(strtolower($nodeName), $this->functions)) {
            return false;
        }

        return true;
    }
}
