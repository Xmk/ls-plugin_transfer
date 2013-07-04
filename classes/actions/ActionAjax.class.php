<?php

class PluginTransfer_ActionAjax extends PluginTransfer_Inherit_ActionAjax {

	protected function RegisterEvent() {
		parent::RegisterEvent();
		$this->AddEventPreg('/^transfer$/i','/^convert$/','EventConvertDomen');
	}

	/**********************************************************************************
	 ************************ РЕАЛИЗАЦИЯ ЭКШЕНА ***************************************
	 **********************************************************************************
	 */

	/**
	 *
	 */
	protected function EventConvertDomen() {
		/**
		 * Проверка доступа
		 */
		if (!$this->User_IsAuthorization() or !$this->oUserCurrent->isAdministrator()) {
			$this->Message_AddErrorSingle($this->Lang_Get('not_access'),$this->Lang_Get('error'));
			return false;
		}
		/**
		 * Получаем данные
		 */
		$sOldHost = getRequestStr('old_host');
		$sOldHost = rtrim($sOldHost, '/');
		if (strpos($sOldHost, 'http://') !== 0) {
			$sOldHost = 'http://'.$sOldHost;
		}
		$sNewHost = Config::Get('path.root.web');
		$sNewHost = rtrim($sNewHost, '/');
		if (strpos($sNewHost, 'http://') !== 0) {
			$sNewHost = 'http://'.$sNewHost;
		}
		/**
		 * Check
		 */
		if (!func_check($sOldHost,'text',2,100)) {
			$this->Message_AddErrorSingle($this->Lang_Get('system_error'),$this->Lang_Get('error'));
			return false;
		}
		if (!func_check($sNewHost,'text',2,100)) {
			$this->Message_AddErrorSingle($this->Lang_Get('system_error'),$this->Lang_Get('error'));
			return false;
		}
		/**
		 * Конверт данных
		 */
		$aEngineTables = Config::Get('plugin.transfer.engine');
		foreach ($aEngineTables as $sConfigTableName => $aFields) {
			$this->PluginTransfer_Transfer_UpdateTable($sConfigTableName, $aFields, $sOldHost, $sNewHost);
		}
		/**
		 * Конверт данных плагинов
		 */
		$aPluginsData = Config::Get('plugin.transfer.plugins');
		foreach ($aPluginsData as $sPluginName => $aPluginsTables) {
			foreach ($aPluginsTables as $sConfigTableName => $aFields) {
				$this->PluginTransfer_Transfer_UpdateTable($sConfigTableName, $aFields, $sOldHost, $sNewHost);
			}
		}
		/**
		 * Сбрасываем кеш
		 */
		$this->Cache_Clean();
		/**
		 * Все хорошо
		 */
		$this->Message_AddNotice('its ok',$this->Lang_Get('attention'));
	}
}
?>