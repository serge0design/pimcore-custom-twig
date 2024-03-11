<?php
declare(strict_types=1);

namespace SergeDesign\PimcoreCustomTwigBundle\Nodes;

use Twig\Compiler;
use Twig\Node\Node;

class SwitchNode extends Node
{

    final public function compile(Compiler $compiler): void
    {
        $compiler
            ->addDebugInfo($this)
            ->write('switch (')
            ->subcompile($this->getNode('value'))
            ->raw("){\n")
            ->indent();

        foreach ($this->getNode('cases') as $case) {
            /**
             * @var Node $case
             */
            if (!$case->hasNode('body')) {
                continue;
            }

            foreach ($case->getNode('values') as $value) {
                $compiler
                    ->write('case ')
                    ->subcompile($value)
                    ->raw(":\n");
            }

            $compiler
                ->write("{\n")
                ->indent()
                ->subcompile($case->getNode('body'))
                ->write("break;\n")
                ->outdent()
                ->write("}\n");
        }

        if ($this->hasNode('default')) {
            $compiler
                ->write("default:\n")
                ->write("{\n")
                ->indent()
                ->subcompile($this->getNode('default'))
                ->outdent()
                ->write("}\n");
        }

        $compiler
            ->outdent()
            ->write("}\n");
    }
}
