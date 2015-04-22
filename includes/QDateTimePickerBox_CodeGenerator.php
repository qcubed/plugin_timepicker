<?php
/**
 * A QCubed composite control to hand off date and time picking to separate date and time picker controls, but have that all
 * part of the same control. See the discussion on composite controls in the examples for how this works.
 *
 * @property QDateTime $DateTime
 * @property-read QDatepickerBox $DatePicker
 * @property-read QTimepickerBox $TimePicker
 * @propert-write boolean $Required
 */
namespace QCubed\Plugin;

use \QControl, \QDateTime, \QCallerException, \QType, \QDatepickerBox, \QCodeGen, \QTable, \QColumn, \QHtml;

class QDateTimePickerBox_CodeGenerator extends \QControl_CodeGenerator {

	public function __construct($strControlClassName = 'QCubed\Plugin\QDateTimePickerBox') {
		parent::__construct($strControlClassName);
	}

	/**
	 * @param string $strPropName
	 * @return string
	 */
	public function VarName($strPropName) {
		return 'dtt' . $strPropName;
	}

	/**
	 * Generate code that will be inserted into the ModelConnector to connect a database object with this control.
	 * This is called during the codegen process.
	 *
	 * @param QCodeGenBase $objCodeGen
	 * @param QTable $objTable
	 * @param mixed $objColumn
	 * @return string
	 */
	public function ConnectorCreate(\QCodeGenBase $objCodeGen, \QTable $objTable, $objColumn) {
		$strControlVarName = $objCodeGen->ModelConnectorVariableName($objColumn);
		$strLabelName = addslashes(QCodeGen::ModelConnectorControlName($objColumn));

		$strControlType = $objCodeGen->GetControlCodeGenerator($objColumn)->GetControlClass();

		$strRet = <<<TMPL
		/**
		 * Create and setup a $strControlType $strControlVarName
		 * @param string \$strControlId optional ControlId to use
		 * @return $strControlType
		 */
		public function {$strControlVarName}_Create(\$strControlId = null) {

TMPL;
		$strControlIdOverride = $objCodeGen->GenerateControlId($objTable, $objColumn);

		if ($strControlIdOverride) {
			$strRet .= <<<TMPL
			if (!\$strControlId) {
				\$strControlId = '$strControlIdOverride';
			}

TMPL;
		}
		$strRet .= <<<TMPL
			\$this->{$strControlVarName} = new $strControlType(\$this->objParentObject, \$strControlId);
			\$this->{$strControlVarName}->Name = QApplication::Translate('$strLabelName');

TMPL;
		$strRet .= static::ConnectorRefresh($objCodeGen, $objTable, $objColumn, true);

		if ($objColumn->NotNull) {
			$strRet .=<<<TMPL
			\$this->{$strControlVarName}->Required = true;

TMPL;
		}

		if ($strMethod = QCodeGen::$PreferredRenderMethod) {
			$strRet .= <<<TMPL
			\$this->{$strControlVarName}->PreferredRenderMethod = '$strMethod';

TMPL;
		}

		$strRet .= static::ConnectorCreateOptions ($objCodeGen, $objTable, $objColumn, $strControlVarName);

		$strRet .= <<<TMPL
			return \$this->{$strControlVarName};
		}


TMPL;

		return $strRet;

	}

	/**
	 * Generate code to reload data from the ModelConnector into this control.
	 * @param QDatabaseCodeGen 	$objCodeGen
	 * @param QTable 			$objTable
	 * @param QColumn 			$objColumn
	 * @param boolean 			$blnInit Is initializing a new control verses loading a previously created control
	 * @return string
	 */
	public function ConnectorRefresh(\QCodeGenBase $objCodeGen, \QTable $objTable, $objColumn, $blnInit = false) {
		$strObjectName = $objCodeGen->ModelVariableName($objTable->Name);
		$strPropName = $objCodeGen->ModelConnectorPropertyName($objColumn);
		$strControlVarName = static::VarName($strPropName);

		if ($blnInit) {
			$strRet = "\t\t\t\$this->{$strControlVarName}->DateTime = \$this->{$strObjectName}->{$strPropName};";
		} else {
			$strRet = "\t\t\tif (\$this->{$strControlVarName}) \$this->{$strControlVarName}->DateTime = \$this->{$strObjectName}->{$strPropName};";
		}
		return $strRet . "\n";
	}


	/**
	 * @param QCodeGenBase $objCodeGen
	 * @param QTable $objTable
	 * @param QColumn|\QReverseReference $objColumn
	 * @return string
	 */
	public function ConnectorUpdate(\QCodeGenBase $objCodeGen, \QTable $objTable, $objColumn) {
		$strObjectName = $objCodeGen->ModelVariableName($objTable->Name);
		$strPropName = $objCodeGen->ModelConnectorPropertyName($objColumn);
		$strControlVarName = static::VarName($strPropName);
		$strRet = <<<TMPL
				if (\$this->{$strControlVarName}) \$this->{$strObjectName}->{$objColumn->PropertyName} = \$this->{$strControlVarName}->DateTime;

TMPL;
		return $strRet;
	}


}
?>
