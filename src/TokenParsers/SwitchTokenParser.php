<?php
declare(strict_types=1);

namespace SergeDesign\PimcoreCustomTwigBundle\TokenParsers;

use Twig\Error\SyntaxError;
use Twig\Node\Node;
use Twig\Token;
use Twig\TokenParser\AbstractTokenParser;
use SergeDesign\PimcoreCustomTwigBundle\Nodes\SwitchNode;

class SwitchTokenParser extends AbstractTokenParser
{

    /**
     * @inheritdoc
     */
    final public function getTag(): string
    {
        return 'switch';
    }

    /**
     * @inheritdoc
     */
    final public function parse(Token $token): SwitchNode
    {
        $lineno = $token->getLine();
        $parser = $this->parser;
        $stream = $parser->getStream();

        $nodes = [
            'value' => $parser->getExpressionParser()->parseExpression(),
        ];

        $stream->expect(Token::BLOCK_END_TYPE);

        // there can be some whitespace between the {% switch %} and the first {% case %} tag.
        while ($stream->getCurrent()->getType() == Token::TEXT_TYPE &&
            trim($stream->getCurrent()->getValue()) === '') {
            $stream->next();
        }

        $stream->expect(Token::BLOCK_START_TYPE);

        $expressionParser = $parser->getExpressionParser();
        $cases = [];
        $end_switch = false;

        while (!$end_switch) {
            $next = $stream->next();

            switch ($next->getValue()) {
                case 'case':
                    $vlaues = [];
                    while (true) {
                        $values[] = $expressionParser->parseExpression();
                        // Multible allowed values?
                        if ($stream->test(Token::OPERATOR_TYPE, 'or')) {
                            $stream->next();
                        } else {
                            break;
                        }
                    }

                    $stream->expect(Token::BLOCK_END_TYPE);
                    $body = $parser->subparse([$this, 'decideIfFork']);
                    $cases[] = new Node([
                        'values' => new Node($values),
                        'body' => $body
                    ]);
                    break;

                case 'default':
                    $stream->expect(Token::BLOCK_END_TYPE);
                    $nodes['default'] = $parser->subparse([$this, 'decideIfEnd']);
                    break;

                case 'endswitch':
                    $end_switch = true;
                    break;
                default:
                    throw new SyntaxError(sprintf(
                        'Unexpected end of template.
                        Twig was looking for the following tags "case", "default", or "endswitch"
                        to close the "switch" block started at line %d)',
                        $lineno
                    ), -1);
            }
        }

        $nodes['cases'] = new Node($cases);
        $stream->expect(Token::BLOCK_END_TYPE);

        return new SwitchNode($nodes, [], $lineno, $this->getTag());
    }

    /**
     * @param Token $token
     * @return bool
     */
    final public function decideIfFork(Token $token): bool
    {
        return $token->test(['case', 'default', 'endswitch']);
    }

    /**
     * @param Token $token
     * @return bool
     */
    final public function decideIfEnd(Token $token): bool
    {
        return $token->test(['endswitch']);
    }
}
