<?php
declare(strict_types=1);

namespace Nelson\Latte\Filters\YouTubeFilter\DI;

use Nelson\Latte\Filters\YouTubeFilter\YouTubeFilter;
use Nette\DI\CompilerExtension;
use Nette\DI\Definitions\FactoryDefinition;
use Nette\Schema\Expect;
use Nette\Schema\Schema;

final class YouTubeFilterExtension extends CompilerExtension
{

	/** @var YouTubeFilterConfig[] */
	public $config;


	public function getConfigSchema(): Schema
	{
		return Expect::from(new YouTubeFilterConfig);
	}


	public function loadConfiguration(): void
	{
		$builder = $this->getContainerBuilder();
		$config = $this->getConfig();
		$builder->addDefinition($this->prefix('default'))
			->setClass(YouTubeFilter::class)
			->addSetup('setup', [$config]);
	}


	public function beforeCompile(): void
	{
		$builder = $this->getContainerBuilder();

		// Latte filter
		$latteFactoryName = 'latte.latteFactory';
		if ($builder->hasDefinition($latteFactoryName)) {
			/** @var FactoryDefinition $latteFactory */
			$latteFactory = $builder->getDefinition($latteFactoryName);
			$latteFactory
				->getResultDefinition()
				->addSetup('addFilter', ['youtube', [$this->prefix('@default'), 'inline']]);
		}
	}
}
