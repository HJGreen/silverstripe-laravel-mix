<?php

namespace HJGreen\SilverstripeLaravelMix;

use SilverStripe\Core\Injector\Injectable;
use SilverStripe\View\ThemeResourceLoader;

class MixManifest
{
    use Injectable;

    private array $manifest = [];

    public function __construct()
    {
        $this->read();
    }

    /**
     * @return void
     * @throws \Exception
     */
    private function read()
    {
        $manifest_path = ThemeResourceLoader::inst()->findThemedResource('mix-manifest.json');

        if (!$manifest_path) {
            throw new \Exception("Unable to locate mix-manifest.json");
        }

        $manifest_path = BASE_PATH . '/' . $manifest_path;
        $contents = json_decode(file_get_contents($manifest_path), true);

        $this->manifest = $contents;
    }

    public function getResourcePath(string $path): ?string
    {
        // Check if 'hot' file exists and construct path to the proxy URL
        if ($hot = $this->getHMRConfig()) {
            $url = file_get_contents(BASE_PATH . '/' . $hot);
            if (preg_match("/^https?:(\/\/.*)$/", $url, $matches)) {
                return $matches[1] . $path;
            }
        }

        if (isset($this->manifest[$path])) {
            return ThemeResourceLoader::inst()->findThemedResource($this->manifest[$path]);
        }

        return null;
    }

    private function getHMRConfig(): ?string
    {
        return ThemeResourceLoader::inst()->findThemedResource('hot');
    }
}
