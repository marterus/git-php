<?php

use Tester\Assert;
use Marterus\GitPhp\Git;
use Marterus\GitPhp\GitException;
use Marterus\GitPhp\Tests\AssertRunner;

require __DIR__ . '/bootstrap.php';

$runner = new AssertRunner(__DIR__);
$git = new Git($runner);

$runner->assert(['commit', '-m', 'Commit message']);

$repo = $git->open(__DIR__);
$repo->commit('Commit message');
