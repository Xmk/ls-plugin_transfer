<?php

class PluginTransfer_ModuleTransfer extends Module {

	/**
	 *
	 * @var PluginTransfer_ModuleTransfer_MapperTransfer
	 */
	protected $oMapper;

	public function Init() {
		$this->oMapper = Engine::GetMapper(__CLASS__);
	}

	/**
	 * Get count rows in table to update
	 *
	 * @param string $sTableName
	 * @param string $sField
	 * @param string $sOldHost
	 * @return int
	 */
	public function GetCountRowsToUpdate($sTableName, $sField, $sOldHost) {
		return $this->oMapper->GetCountRowsToUpdate($sTableName, $sField, $sOldHost);
	}

	/**
	 * Update table
	 *
	 * @param string $sConfigTableName
	 * @param array $aFields
	 * @return void
	 */
	public function UpdateTable($sConfigTableName, $aFields, $sOldHost, $sNewHost) {
		$sTableName = Config::Get($sConfigTableName);
		if (!$sTableName || !$this->Database_isTableExists($sTableName)) {
			$this->Message_AddError('Table ' . $sConfigTableName . ' not exist', $this->Lang_Get('error'));
			return;
		}
		foreach ($aFields as $sField) {
			if (!$this->Database_isFieldExists($sTableName, $sField)) {
				$this->Message_AddError('Field ' . $sField . ' not exist in table ' . $sConfigTableName, $this->Lang_Get('error'));
				continue;
			}
			$iCountRow = $this->GetCountRowsToUpdate($sTableName, $sField, $sOldHost);
			if ($iCountRow) {
				$this->UpdateField($sTableName, $sField, $sOldHost, $sNewHost);
			}
		}
	}

	/**
	 * Update field
	 * 
	 * @param string $sTableName
	 * @param string $sField
	 * @param string $sOldHost
	 * @param string $sNewHost
	 * @return boolean
	 */
	public function UpdateField($sTableName, $sField, $sOldHost, $sNewHost) {
		return $this->oMapper->UpdateField($sTableName, $sField, $sOldHost, $sNewHost);
	}

}