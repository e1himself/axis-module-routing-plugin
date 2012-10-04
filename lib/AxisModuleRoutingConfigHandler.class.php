<?php
/**
 * @author Ivan Voskoboynyk
 */
class AxisModuleRoutingConfigHandler extends sfRoutingConfigHandler
{
  protected $routingOptions;
  public function __construct($parameters = null)
  {
    $this->routingOptions = $parameters['routing_options'];
    unset($parameters['routing_options']);
    parent::__construct($parameters);
  }


  protected function getOptions()
  {
    return $this->routingOptions;
  }
}
