<?php

if (!class_exists('Plugin')) {
	die('Hacking attempt!');
}

class PluginTransfer extends Plugin {

	protected $aInherits = array(
		'action' => array(
			'ActionAjax'
		)
	);

}