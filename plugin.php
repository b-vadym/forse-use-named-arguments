<?php

declare(strict_types=1);

namespace Kafkiansky\ReduceArguments;

use PhpParser\Node\Expr;
use Psalm\CodeLocation;
use Psalm\IssueBuffer;
use Psalm\Plugin\EventHandler\AfterExpressionAnalysisInterface;
use Psalm\Plugin\EventHandler\Event\AfterExpressionAnalysisEvent;

final class Hook implements AfterExpressionAnalysisInterface
{
    /**
     * {@inheritdoc}
     */
    public static function afterExpressionAnalysis(AfterExpressionAnalysisEvent $event): ?bool {
        $expr = $event->getExpr();
        if (
            $expr instanceof Expr\MethodCall ||
            $expr instanceof Expr\FuncCall ||
            $expr instanceof Expr\New_ ||
            $expr instanceof Expr\StaticCall
        ) {

            foreach ($expr->getArgs() as $arg) {
                if ($arg->name === null) {
                    $issue = new UseNamedArguments(new CodeLocation($event->getStatementsSource(), $arg));

                    IssueBuffer::maybeAdd($issue, $event->getStatementsSource()->getSuppressedIssues());
                }
            }

        }

        return null;
    }
}


use Psalm\Issue\PluginIssue;

final class UseNamedArguments extends PluginIssue
{
    public function __construct(CodeLocation $codeLocation)
    {
        parent::__construct(
            'You must use named arguments',
            $codeLocation
        );
    }
}
