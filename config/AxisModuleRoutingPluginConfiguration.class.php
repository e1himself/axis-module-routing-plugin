<?php

require_once(__DIR__.'/../lib/AxisModuleRouting.class.php');

/**
 * @author Ivan Voskoboynyk
 */
class AxisModuleRoutingPluginConfiguration extends sfPluginConfiguration
{
	
	public function initialize()
	{
    if (sfConfig::get('app_axis_module_routing_plugin_register_module_routes', true) && $this->configuration instanceof sfApplicationConfiguration)
    {
      $listener = new AxisModuleRouting($this->configuration);
      $this->dispatcher->connect('routing.load_configuration', array($listener, 'listenToRoutingLoadConfigurationEvent'));
    }
	}

}
