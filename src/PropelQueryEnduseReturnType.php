<?php

namespace Acme;

use PhpParser\Node\Expr\MethodCall;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\MethodReflection;
use PHPStan\ShouldNotHappenException;
use PHPStan\Type\DynamicMethodReturnTypeExtension;
use PHPStan\Type\Type;
use PHPStan\Type\ObjectType;

class PropelQueryEnduseReturnType implements DynamicMethodReturnTypeExtension
{
  public function getClass(): string
  {
    return \ModelCriteria::class;
  }

  public function isMethodSupported(MethodReflection $methodReflection): bool
  {
    return $methodReflection->getName() === 'endUse';
  }

  public function getTypeFromMethodCall(MethodReflection $methodReflection, MethodCall $methodCall, Scope $scope): Type
  {
    $callStack = [];
    $useStack = [];

    do {
      $methodCall = $methodCall->var;
      $callStack[] = $methodCall;
      if ($this->isUseMethod($methodCall)) {
        $useStack[] = $methodCall;
      }
    } while (isset($methodCall->var));

    $callStack = array_reverse($callStack);
    $useStack = array_reverse($useStack);

    // TODO: pop from useStack for each endUse in the call stack
    // for some reason only the first endUse is passed to this handler
    // so there is no way to actually fix this.

    /*
    echo "Call stack:\n";
    $this->printDebugStack($callStack);
    echo "Use stack:\n";
    $this->printDebugStack($useStack);
    echo "\n\n";
    */

    $callerType = $scope->getType(array_pop($useStack));

    return $callerType;
  }

  private function isUseMethod($expr)
  {
    return strtolower(substr($expr->name->name, 0, 3)) === 'use';
  }

  private function printDebugStack($stack)
  {
    array_map(function($e) {
      dump($e->name->name);
    }, $stack);
    echo "\n\n";
  }
}
