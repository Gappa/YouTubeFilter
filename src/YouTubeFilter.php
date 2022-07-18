<?php
declare(strict_types=1);

namespace Nelson\Latte\Filters\YouTubeFilter;

use Nelson\Latte\Filters\YouTubeFilter\DI\YouTubeFilterConfig;
use Nette\SmartObject;
use Nette\Utils\Html;

class YouTubeFilter
{
	use SmartObject;

	/** @var string */
	public const URL_REGEXP = '/^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#\&\?]*).*/';

	/** @var string */
	public const URL_EMBED = 'https://www.youtube.com/embed/';

	private string $cssClass;


	public function setup(YouTubeFilterConfig $config): void
	{
		$this->cssClass = $config->cssClass;
	}


	public function inline(string $url, string $param): ?Html
	{
		/** @var array<int, string>|false $dims */
		$dims = explode('x', $param);

		if ($dims === false) {
			return null;
		}

		preg_match(static::URL_REGEXP, $url, $matches);

		if (!isset($matches[7])) {
			return null;
		}
		
		return Html::el('div')
			->setAttribute('class', $this->cssClass)
			->addHtml(
				Html::el('iframe')
				->setAttribute('src', static::URL_EMBED . $matches[7] . '?wmode=transparent')
				->setAttribute('wmode', 'opaque')
				->setAttribute('width', $dims[0])
				->setAttribute('height', $dims[1])
				->setAttribute('frameborder', 0)
				->setAttribute('allowfullscreen', true)
			);
	}
}
