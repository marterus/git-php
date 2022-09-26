<?php

	namespace Marterus\GitPhp\Runners;

	use Marterus\GitPhp\CommandProcessor;
	use Marterus\GitPhp\GitException;
	use Marterus\GitPhp\IRunner;
	use Marterus\GitPhp\RunnerResult;


	class MemoryRunner implements IRunner
	{
		/** @var string */
		private $cwd;

		/** @var CommandProcessor */
		private $commandProcessor;

		/** @var array<string, RunnerResult>  [command => RunnerResult] */
		private $results = [];


		/**
		 * @param  string $cwd
		 */
		public function __construct($cwd)
		{
			$this->cwd = $cwd;
			$this->commandProcessor = new CommandProcessor;
		}


		/**
		 * @param  array<mixed> $args
		 * @param  array<string, scalar> $env
		 * @param  array<string> $output
		 * @param  array<string> $errorOutput
		 * @param  int $exitCode
		 * @return self
		 */
		public function setResult(array $args, array $env, array $output, array $errorOutput = [], $exitCode = 0)
		{
			$cmd = $this->commandProcessor->process('git', $args, $env);
			$this->results[$cmd] = new RunnerResult($cmd, $exitCode, $output, $errorOutput);
			return $this;
		}


		/**
		 * @return RunnerResult
		 */
		public function run($cwd, array $args, array $env = NULL)
		{
			$cmd = $this->commandProcessor->process('git', $args, $env);

			if (!isset($this->results[$cmd])) {
				throw new \Marterus\GitPhp\InvalidStateException("Missing result for command '$cmd'.");
			}

			return $this->results[$cmd];
		}


		/**
		 * @return string
		 */
		public function getCwd()
		{
			return $this->cwd;
		}
	}
