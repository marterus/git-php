<?php

use Tester\Assert;
use Marterus\GitPhp\Git;
use Marterus\GitPhp\GitException;
use Marterus\GitPhp\Runners\MemoryRunner;

require __DIR__ . '/bootstrap.php';

$runner = new MemoryRunner(__DIR__);
$git = new Git($runner);
$repo = $git->open(__DIR__);

$runner->setResult(['branch', '-r', '--no-color'], [], [
	'  origin/master',
	'* origin/version-2'
]);
Assert::same([
	'origin/master',
	'origin/version-2',
], $repo->getRemoteBranches());


$runner->setResult(['branch', '-r', '--no-color'], [], []);
Assert::null($repo->getRemoteBranches());
