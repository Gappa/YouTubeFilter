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

	/** @var string */
	private $cssClass;


	public function setup(YouTubeFilterConfig $config): void
	{
		$this->cssClass = $config->cssClass;
	}


	public function inline(string $url, string $param): ?Html
	{
		/** @var array|false $dims */
		$dims = explode('x', $param);

		if (!empty($url)) {
			preg_match(static::URL_REGEXP, $url, $matches);

			if (isset($matches[7])) {
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
	}
}
