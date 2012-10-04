<?php

require_once(__DIR__.'/../lib/AxisModuleRouting.class.php');

/**
 * @author Ivan Voskoboynyk
 */
class AxisModuleRoutingPluginConfiguration extends sfPluginConfiguration
{
	
	public function initialize()
	{
    $listener = new AxisModuleRouting($this->configuration);
    $this->dispatcher->connect('routing.load_configuration', array($listener, 'listenToRoutingLoadConfigurationEvent'));
	}

}
