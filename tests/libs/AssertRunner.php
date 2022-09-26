<?php

	namespace Marterus\GitPhp\Tests;

	use Marterus\GitPhp\CommandProcessor;
	use Marterus\GitPhp\GitException;
	use Marterus\GitPhp\IRunner;
	use Marterus\GitPhp\RunnerResult;


	class AssertRunner implements \Marterus\GitPhp\IRunner
	{
		/** @var string */
		private $cwd;

		/** @var CommandProcessor */
		private $commandProcessor;

		/** @var array  [command => RunnerResult] */
		private $asserts = [];


		/**
		 * @param  string $cwd
		 */
		public function __construct($cwd)
		{
			$this->cwd = $cwd;
			$this->commandProcessor = new CommandProcessor;
		}


		public function assert(array $expectedArgs, array $expectedEnv = [], array $resultOutput = [], array $resultErrorOutput = [], $resultExitCode = 0)
		{
			$cmd = $this->commandProcessor->process('git', $expectedArgs, $expectedEnv);
			$this->asserts[] = new RunnerResult($cmd, $resultExitCode, $resultOutput, $resultErrorOutput);
			return $this;
		}


		public function resetAsserts()
		{
			$this->asserts = [];
			return $this;
		}


		/**
		 * @return RunnerResult
		 */
		public function run($cwd, array $args, array $env = NULL)
		{
			if (empty($this->asserts)) {
				throw new \Marterus\GitPhp\InvalidStateException('Missing asserts, use $runner->assert().');
			}

			$cmd = $this->commandProcessor->process('git', $args, $env);
			$result = current($this->asserts);

			if (!($result instanceof RunnerResult)) {
				throw new \Marterus\GitPhp\InvalidStateException("Missing assert for command '$cmd'");
			}

			\Tester\Assert::same($result->getCommand(), $cmd);
			next($this->asserts);
			return $result;
		}


		/**
		 * @return string
		 */
		public function getCwd()
		{
			return $this->cwd;
		}
	}
