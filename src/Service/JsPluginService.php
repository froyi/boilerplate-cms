<?php declare(strict_types=1);

namespace Project\Service;

use Project\Configuration;

/**
 * Class JsPluginService
 * @package Project\Service
 */
class JsPluginService
{
    protected const PACKAGES_NAME = 'js-packages';

    /** @var Configuration $configuration */
    private $configuration;

    /**
     * JsPluginService constructor.
     *
     * @param Configuration $configuration
     */
    public function __construct(Configuration $configuration)
    {
        $this->configuration = $configuration;
    }

    /**
     *
     *
     * @return array
     * @throws \InvalidArgumentException
     */
    public function getMainPackages(): array
    {
        $jsMainPackage = [];
        $jsBox = $this->configuration->getEntryByName('js-boxes');

        if (isset($jsBox['main'])) {
            foreach ($jsBox['main'] as $package => $enabled) {
                if ($enabled === true) {
                    $jsMainPackage[] = $this->getPackageByPackageName($package);
                }
            }
        }

        return $jsMainPackage;
    }

    /**
     *
     *
     * @param string $routeName
     *
     * @return array
     * @throws \InvalidArgumentException
     */
    public function getPackagesByRouteName(string $routeName): array
    {
        $jsRoutePackage = [];
        $jsBox = $this->configuration->getEntryByName('js-boxes');

        if (empty($jsBox) === false && empty($jsBox[$routeName]) === false) {
            foreach ($jsBox[$routeName] as $routePackage => $enabled) {
                if ($enabled === true) {
                    $jsRoutePackage[] = $this->getPackageByPackageName($routePackage);
                }
            }
        }

        return $jsRoutePackage;
    }

    /**
     *
     *
     * @param string $packageName
     *
     * @return string
     * @throws \InvalidArgumentException
     */
    protected function getPackageByPackageName(string $packageName): string
    {
        $jsPackage = $this->configuration->getEntryByName('js-packages');

        if (isset($jsPackage[$packageName]) === false) {
            return '';
        }
        return $jsPackage[$packageName];
    }
}