<?php

use Tester\Assert;
use Marterus\GitPhp\Git;
use Marterus\GitPhp\Runners\MemoryRunner;

require __DIR__ . '/bootstrap.php';

$runner = new MemoryRunner(__DIR__);
$git = new Git($runner);
$repo = $git->open(__DIR__);

$runner->setResult(['branch'], [], [
	'* master',
]);
Assert::same([
	'* master',
], $repo->execute('branch'));


$runner->setResult(['remote', '-v'], [], []);
Assert::same([], $repo->execute(['remote', '-v']));

$runner->setResult(['remote', 'add', 'origin', 'https://github.com/Marterus/git-php.git'], [], []);
$repo->execute(['remote', 'add', 'origin', 'https://github.com/Marterus/git-php.git']);

$runner->setResult(['remote', '-v'], [], [
	"origin\thttps://github.com/Marterus/git-php.git (fetch)",
	"origin\thttps://github.com/Marterus/git-php.git (push)",
]);
Assert::same([
	"origin\thttps://github.com/Marterus/git-php.git (fetch)",
	"origin\thttps://github.com/Marterus/git-php.git (push)",
], $repo->execute(['remote', '-v']));


$runner->setResult(['blabla'], [], [], [], 1);
Assert::exception(function () use ($repo) {
	$repo->execute('blabla');
}, Marterus\GitPhp\GitException::class, "Command 'git blabla' failed (exit-code 1).");
