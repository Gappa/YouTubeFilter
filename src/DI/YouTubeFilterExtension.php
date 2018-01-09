<?php

namespace Nelson\Latte\Filters\YouTubeFilter\DI;

use Latte\Engine;
use Nelson\Latte\Filters\YouTubeFilter\YouTubeFilter;
use Nette\Bridges\ApplicationLatte\ILatteFactory;
use Nette\DI\CompilerExtension;
use Nette\DI\ServiceDefinition;

final class YouTubeFilterExtension extends CompilerExtension
{

	/** @var array */
	protected $defaults = [];


	public function loadConfiguration()
	{
		$builder = $this->getContainerBuilder();
		$config = $this->getConfig($this->defaults);
		$builder->addDefinition($this->prefix('default'))
			->setClass(YouTubeFilter::class);
	}


	public function beforeCompile()
	{
		$builder = $this->getContainerBuilder();

		$registerToLatte = function (ServiceDefinition $def) {
			$def->addSetup('addFilter', ['youtube', [$this->prefix('@default'), 'inline']]);
		};

		$latteFactoryService = $builder->getByType(ILatteFactory::class);
		if (!$latteFactoryService || !self::isOfType($builder->getDefinition($latteFactoryService)->getClass(), Engine::class)) {
			$latteFactoryService = 'nette.latteFactory';
		}

		if ($builder->hasDefinition($latteFactoryService) && self::isOfType($builder->getDefinition($latteFactoryService)->getClass(), Engine::class)) {
			$registerToLatte($builder->getDefinition($latteFactoryService));
		}

		if ($builder->hasDefinition('nette.latte')) {
			$registerToLatte($builder->getDefinition('nette.latte'));
		}
	}


	/**
	 * @param string $class
	 * @param string $type
	 * @return bool
	 */
	private static function isOfType($class, $type)
	{
		return $class === $type || is_subclass_of($class, $type);
	}
}
