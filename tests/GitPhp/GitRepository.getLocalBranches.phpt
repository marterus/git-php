<?php

use Tester\Assert;
use Marterus\GitPhp\Git;
use Marterus\GitPhp\GitException;
use Marterus\GitPhp\Runners\MemoryRunner;

require __DIR__ . '/bootstrap.php';

$runner = new MemoryRunner(__DIR__);
$git = new Git($runner);
$repo = $git->open(__DIR__);

$runner->setResult(['branch', '--no-color'], [], [
	'  master',
	'* develop',
]);
Assert::same([
	'master',
	'develop',
], $repo->getLocalBranches());


$runner->setResult(['branch', '--no-color'], [], []);
Assert::null($repo->getLocalBranches());
