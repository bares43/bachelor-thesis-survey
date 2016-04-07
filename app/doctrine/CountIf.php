<?php
namespace App\Doctrine;
use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;

class CountIf extends FunctionNode {

    /**
     * @var String
     */
    private $column;

    /**
     * @var String
     */
    private $cond;

    /**
     * @var String
     */
    private $value;

    /**
     * @param SqlWalker $sqlWalker
     *
     * @return string
     */
    public function getSql(SqlWalker $sqlWalker)
    {
        return "COUNT(CASE WHEN $this->column $this->cond $this->value THEN 1 END)";
    }
    /**
     * @param Parser $parser
     */
    public function parse(Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);
        $this->column = $parser->StringPrimary()->value;
        $parser->match(Lexer::T_COMMA);
        $this->cond = $parser->StringPrimary()->value;
        $parser->match(Lexer::T_COMMA);
        $this->value = $parser->StringExpression()->value;
        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }
}