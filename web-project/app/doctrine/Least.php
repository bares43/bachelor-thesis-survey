<?php
namespace App\Doctrine;
use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\AST\PathExpression;
use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;

class Least extends FunctionNode {
    /**
     * @var array
     */
    protected $leastArgs;
    /**
     * @param SqlWalker $sqlWalker
     *
     * @return string
     */
    public function getSql(SqlWalker $sqlWalker)
    {
        return sprintf('LEAST(%s)',
            implode(', ', array_map(
                function(PathExpression $expression) use($sqlWalker) {
                    return $expression->dispatch($sqlWalker);
                },
                $this->leastArgs
            ))
        );
    }
    /**
     * @param Parser $parser
     */
    public function parse(Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);
        // 2 arguments minimum
        $this->leastArgs[] = $parser->ArithmeticPrimary();
        $parser->match(Lexer::T_COMMA);
        $this->leastArgs[] = $parser->ArithmeticPrimary();
        while ($parser->getLexer()->isNextToken(Lexer::T_COMMA)) {
            $parser->match(Lexer::T_COMMA);
            $this->leastArgs[] = $parser->ArithmeticPrimary();
        }
        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }
}