<?php

class PluginTransfer_HookAdmin extends Hook {
	public function RegisterHook() {
		$this->AddHook('template_admin_action_item','tplAdminActionItem');
	}

	public function tplAdminActionItem() {
		return $this->Viewer_Fetch(Plugin::GetTemplatePath(__CLASS__).'inject.admin_action_item.tpl');
	}
}
?>