<?php

namespace Nelson\Latte\Filters\YouTubeFilter\DI;

use Nelson\Latte\Filters\YouTubeFilter\YouTubeFilter;
use Nette\DI\CompilerExtension;
use Nette\DI\Definitions\FactoryDefinition;

final class YouTubeFilterExtension extends CompilerExtension
{

	public function loadConfiguration(): void
	{
		$builder = $this->getContainerBuilder();
		$builder->addDefinition($this->prefix('default'))
			->setClass(YouTubeFilter::class);
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
