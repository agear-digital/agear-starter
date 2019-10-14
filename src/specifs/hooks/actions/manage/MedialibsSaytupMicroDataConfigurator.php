<?php
/**
 * MedialibsSaytupMicroDataConfigurator
 *
 * 
 *
 * @author Medialibs
 *
 * @date 2018-07-12
 */

require_once \em_misc::getSpecifPath() . '/addons/MedialibsSaytupMicroDataConfigurator/class/tools/interface/InterfaceScreen.class.php';

class MedialibsSaytupMicroDataConfigurator
{
	public function start()
	{
		$is = new Addon\MedialibsSaytupMicroDataConfigurator\InterfaceScreen();
		$is->start();
	}
}