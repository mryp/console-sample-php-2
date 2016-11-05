<?php
/**
 * 全般設定
 */
class SiteSettingItem
{
	private $_serviceName = "";
	private $_footer = "";

	/**
	 * サービス名称
	 */
	public function getServiceName()
	{
		return $this->_serviceName;
	}
	
	public function getFooter()
	{
		return $this->_footer;
	}

	public function __construct($serviceName, $footer)
	{
		$this->_serviceName = $serviceName;
		$this->_footer = $footer;
	}
}
