# Silverstripe Laravel Mix

Support for [Laravel Mix][laravel_mix], including Webpack Hot Module Replacement.

**Not recommended for use in production whilst under development.**

## Usage

This example assumes [a theme has been configured][theme_configuration] and that Laravel Mix is configured to output in the `dist/` directory of the theme.

```php
use HJGreen\SilverstripeLaravelMix\Mix;
use SilverStripe\CMS\Controllers\ContentController;
use SilverStripe\Control\Director;
use SilverStripe\View\Requirements;
use SilverStripe\View\ThemeResourceLoader;

class PageController extends ContentController {
    public function init(){
        parent::init();
        
        if (Director::isDev()) {
            Requirements::css(Mix::resolve('/dist/styles.css'));
            Requirements::javascript(Mix::resolve('/dist/index.js'));
        } else {
            $theme = ThemeResourceLoader::inst();
            Requirements::css($theme->findThemedCSS('/dist/styles.css'));
            Requirements::javascript($theme->findThemedJavascript('/dist/index.js'));
        }
    }
}
```

[laravel_mix]: https://laravel-mix.com/docs
[theme_configuration]: https://docs.silverstripe.org/en/4/developer_guides/templates/themes/#configuring-themes
