<?php

use Tester\Assert;
use Marterus\GitPhp\Helpers;

require __DIR__ . '/bootstrap.php';


Assert::same('repo', Helpers::extractRepositoryNameFromUrl('/path/to/repo.git'));
Assert::same('repo', Helpers::extractRepositoryNameFromUrl('/path/to/repo/.git'));
Assert::same('foo', Helpers::extractRepositoryNameFromUrl('host.xz:foo/.git'));
Assert::same('repo', Helpers::extractRepositoryNameFromUrl('file:///path/to/repo.git/'));
Assert::same('git-php', Helpers::extractRepositoryNameFromUrl('https://github.com/Marterus/git-php.git'));
Assert::same('git-php', Helpers::extractRepositoryNameFromUrl('git@github.com:Marterus/git-php.git'));
