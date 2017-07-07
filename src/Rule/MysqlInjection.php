<?php
namespace Psecio\Parse\Rule;
use Psecio\Parse\RuleInterface;
use PhpParser\Node;
use PhpParser\Node\Expr\BinaryOp\Concat;
use PhpParser\Node\Scalar\String_;
use PhpParser\Node\Expr\Variable;

/**
 * Use prepared statements in the MySQL query. Don't append the php variable to the query.
 *
 *
 * @todo Add long description to docblock
 */
class MysqlInjection implements RuleInterface
{
    use Helper\NameTrait, Helper\DocblockDescriptionTrait;

    public function isValid(Node $node)
    {
        if ($node instanceof Concat) {
            if ($node->left && $node->left instanceof String_) {
                return !(self::isMysqlString($node->left) && ($node->right instanceof Variable));
            }
        }
        return true;
    }

    private static function isMysqlString(String_ $query){
        return preg_match("/((SELECT|select|INSERT|insert|DELETE|delete|UPDATE|update).(.|\n)*).(FROM|from|INTO|into|SET|set)/", $query->value);
    }
}
