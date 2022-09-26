<?php

use Tester\Assert;
use Marterus\GitPhp\Git;
use Marterus\GitPhp\GitException;
use Marterus\GitPhp\Runners\MemoryRunner;

require __DIR__ . '/bootstrap.php';

$runner = new MemoryRunner(__DIR__);
$git = new Git($runner);

$repoA = $git->open(__DIR__);
Assert::same(__DIR__, $repoA->getRepositoryPath());

$repoA = $git->open(__DIR__ . '/.git');
Assert::same(__DIR__, $repoA->getRepositoryPath());

$repoA = $git->open(__DIR__ . '/.git/');
Assert::same(__DIR__, $repoA->getRepositoryPath());


Assert::exception(function () use ($git) {
	$git->open(__DIR__ . '/unexists');

}, GitException::class, "Repository '" . __DIR__ . "/unexists' not found.");
