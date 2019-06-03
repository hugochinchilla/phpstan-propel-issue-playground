<?php

namespace Acme;

class ExampleClass
{
  public function doSomething()
  {
    return \BookQuery::create()
      ->useAuthorQuery()
        ->useAuthorKVQuery()
          ->filterByKey("foo")
          ->filterByValue("bar")
        ->endUse()
      ->endUse()
      ->filterByLastName("Hemingway");
  }
}
