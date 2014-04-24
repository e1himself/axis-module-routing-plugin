<?php

/**
 * @author Ivan Voskoboynyk
 */
class AxisModuleRouting
{
  protected $routes = array();
  /**
   * @var sfApplicationConfiguration
   */
  protected $configuration;

  public function __construct(sfProjectConfiguration $configuration)
  {
    $this->configuration = $configuration;
  }

  /**
   * @param sfRouting $routing
   * @param array|string[] $modules
   * @return array
   */
  private function loadModuleRouting($routing, $modules = null)
  {
    $routingOptions = $routing->getOptions();

    $modules = $modules === null ? sfConfig::get('sf_enabled_modules') : $modules;

    /** @var $configCache sfConfigCache */
    $configCache = $this->configuration->getConfigCache();
    $configCache->registerConfigHandler('config/module_routing.yml', 'AxisModuleRoutingConfigHandler', array('routing_options' => $routingOptions));

    $usedModules = array();
    foreach ($modules as $module)
    {
      $cached = $configCache->checkConfig("modules/$module/config/module_routing.yml", true);
      if ($cached)
      {
        $usedModules[] = $module;
        include $cached;
      }
    }
    return $usedModules;
  }

  public function listenToRoutingLoadConfigurationEvent(sfEvent $event)
  {
    $routing = $event->getSubject();

    if (!sfConfig::get('sf_debug')) // handle caching in non-debug environment
    {
      $cache = new sfFileCache(array('cache_dir' => sfConfig::get('sf_app_cache_dir')));
      $key = __CLASS__.'/modules';

      if ($cache->has($key))
      {
        $modules = unserialize($cache->get($key));
        $this->loadModuleRouting($routing, $modules);
      }
      else {
        $modules = $this->loadModuleRouting($routing);
        $cache->set($key, serialize($modules));
      }
    }
    else
    {
      $this->loadModuleRouting($routing);
    }

    if (!count($this->routes))
    {
      return;
    }

    $prepend = array();
    $append = array();

    foreach ($this->routes as $name => $route)
    {
      /** @var $route sfRoute */
      if (is_string($route))
      {
        $route = unserialize($route);
      }
      $options = $route->getOptions();
      if (isset($options['position']) && $options['position'] == 'last')
      {
        $append[$name] = $route;
      }
      else
      {
        $prepend[$name] = $route;
      }
    }

    foreach (array_reverse($prepend) as $name => $route)
    {
      $routing->prependRoute($name, $route);
    }

    foreach ($append as $name => $route)
    {
      $routing->appendRoute($name, $route);
    }
  }
}
