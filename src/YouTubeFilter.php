<?php

namespace Nelson\Latte\Filters\YouTubeFilter;

use Nette\SmartObject;
use Nette\Utils\Html;

/**
 * Usage: {='https://www.youtube.com/watch?v=WRt4wx-norQ', '800x450'|youtube}
 */
class YouTubeFilter
{
	use SmartObject;

	const URL_REGEXP = '/^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#\&\?]*).*/';
	const URL_EMBED = 'https://www.youtube.com/embed/';
	const CSS_CLASS = 'yt-video';


	/**
	 * @param  string $url
	 * @param  string $param
	 * @return Html|void
	 */
	public static function inline($url, $param)
	{
		$dims = explode('x', $param);

		if (!empty($url)) {
			preg_match(static::URL_REGEXP, $url, $matches);

			if (isset($matches[7])) {
				return Html::el('div')
					->class(static::CSS_CLASS)
					->addHtml(
						Html::el('iframe')
							->src(static::URL_EMBED . $matches[7] . '?wmode=transparent')
							->width($dims[0])
							->height($dims[1])
							->frameborder(0)
							->wmode('opaque')
							->allowfullscreen(true)
					);
			}
		}
	}
}
