<?php

namespace HJGreen\SilverstripeLaravelMix;

use SilverStripe\Core\Injector\Injectable;

class Mix
{
    use Injectable;

    private MixManifest $manifest;

    public function __construct()
    {
        $this->manifest = MixManifest::singleton();
    }

    public static function resolve(string $path): ?string
    {
        return self::singleton()->manifest->getResourcePath($path);
    }
}
