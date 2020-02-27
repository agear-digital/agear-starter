<?php
/**
 * MedialibsIntegrationFacilitator
 *
 * 
 *
 * @author Medialibs
 *
 * @date 2018-07-12
 */

require_once \em_misc::getSpecifPath() . '/addons/MedialibsIntegrationFacilitator/class/tools/interface/InterfaceScreen.class.php';

class MedialibsIntegrationFacilitator
{
	public function start()
	{
		$is = new Addon\MedialibsIntegrationFacilitator\InterfaceScreen();
		$is->start();
	}
}