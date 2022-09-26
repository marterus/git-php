<?php

use Tester\Assert;
use Marterus\GitPhp\Git;
use Marterus\GitPhp\GitException;
use Marterus\GitPhp\Tests\AssertRunner;

require __DIR__ . '/bootstrap.php';

$runner = new AssertRunner(__DIR__);
$git = new Git($runner);

$runner->assert(['branch', '--end-of-options', 'master']);
$runner->assert(['branch', '--end-of-options', 'develop']);
$runner->assert(['checkout', 'develop']);
$runner->assert(['merge', '--end-of-options', 'feature-1']);
$runner->assert(['branch', '-d', 'feature-1']);
$runner->assert(['checkout', 'master']);

$repo = $git->open(__DIR__);
$repo->createBranch('master');
$repo->createBranch('develop', TRUE);
$repo->merge('feature-1');
$repo->removeBranch('feature-1');
$repo->checkout('master');
