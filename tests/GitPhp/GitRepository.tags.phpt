<?php

use Tester\Assert;
use Marterus\GitPhp\Git;
use Marterus\GitPhp\GitException;
use Marterus\GitPhp\Tests\AssertRunner;

require __DIR__ . '/bootstrap.php';

$runner = new AssertRunner(__DIR__);
$git = new Git($runner);

$runner->assert(['tag', '--end-of-options', 'v1.0.0']);
$runner->assert(['tag', '--end-of-options', 'v2.0.0', 'v1.0.0']);
$runner->assert(['tag', '-d', 'v1.0.0']);
$runner->assert(['tag', '-d', 'v2.0.0']);

$repo = $git->open(__DIR__);
$repo->createTag('v1.0.0');
$repo->renameTag('v1.0.0', 'v2.0.0');
$repo->removeTag('v2.0.0');
