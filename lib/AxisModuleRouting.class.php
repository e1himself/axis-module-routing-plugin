<?php

/**
 * @author Ivan Voskoboynyk
 */
class AxisModuleRouting
{
  protected $routes = array();
  protected $configuration;

  public function __construct(sfProjectConfiguration $configuration)
  {
    $this->configuration = $configuration;
  }

  public function listenToRoutingLoadConfigurationEvent(sfEvent $event)
  {
    /** @var $configCache sfConfigCache */
    $configCache = $this->configuration->getConfigCache();

    $routing = $event->getSubject();
    $routingOptions = $routing->getOptions();
    $configCache->registerConfigHandler('config/module_routing.yml', "AxisModuleRoutingConfigHandler", array('routing_options' => $routingOptions));

    foreach (sfConfig::get('sf_enabled_modules') as $module)
    {
      $cached = $configCache->checkConfig("modules/$module/config/module_routing.yml", true);
      if ($cached)
      {
        include $cached;
      }
    }

    if (!count($this->routes))
    {
      return;
    }

    foreach ($this->routes as $name => $route)
    {
      /* @var $route sfRoute */
      $options = $route->getOptions();
      if (isset($options['position']) && $options['position'] == 'last')
      {
        $routing->appendRoute($name, $route);
      }
      else
      {
        $routing->prependRoute($name, $route);
      }
    }
  }

}