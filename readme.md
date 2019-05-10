# Installation

1. Composer: `composer require nelson/youtubefilter`
2. Register:
	```
	extensions:
		youTubeFilter: Nelson\Latte\Filters\YouTubeFilter\DI\YouTubeFilterExtension
	```
3. Optional config:
	```
	youTubeFilter:
		cssClass: 'css-class-for-wrapper-div'
	```

# Usage

Latte:

```
{='https://www.youtube.com/watch?v=WRt4wx-norQ', '800x450'|youtube}
```

