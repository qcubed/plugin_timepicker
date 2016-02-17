<?php
	/** 
	*
	*	API for the jquery.ui.timepicker.js jQuery widget. This closely reflects what
	*	is in the actual jQuery plugin.
	*
	* @property string $TimeSeparator The character to use to separate hours and minutes. (default: ':')
	* @property bool $ShowLeadingZero Define whether or not to show a leading zero for hours < 10. (default: true)
	* @property bool $ShowMinutesLeadingZero Define whether or not to show a leading zero for minutes < 10. (default: true)
	* @property bool $ShowPeriod Define whether or not to show AM/PM with selected time. (default: false)
	* @property bool $ShowPeriodLabels Define if the AM/PM labels on the left are displayed. (default: true)
	* @property string $PeriodSeparator The character to use to separate the time from the time period.
	* @property string $AltField Define an alternate input to parse selected time to
	* @property string $DefaultTime Used as default time when input field is empty or for inline 
	* 		timePicker (set to 'now' for the current time, '' for no highlighted time, default value: now)
	* @property string $ShowOn Define when the timepicker is shown.
	*                          'focus': when the input gets focus, 'button' when the button trigger element is clicked,
	*                          'both': when the input gets focus and when the button is clicked.
	* @property string $Button jQuery selector that acts as button trigger. ex: '#trigger_button'
	* @property string $HourText Define the locale text for "Hours"
	* @property string $MinuteText Define the locale text for "Minute"
	* @property string $AmPmText Define the locale text for periods
	* @property string $MyPosition Corner of the dialog to position, used with the jQuery UI Position utility if present.
	* @property string $AtPosition Corner of the input to position
	* @property string $AtPosition Corner of the input to position
	* @property array $HoursArray Custom hours. Keys: 
	* 	 starts:0		 number to start with 
	* 	 ends:23 		 number to end with
	* @property array $MinutesArray Custom minutes. Keys: 
	*	 starts: 0,                 First displayed minute
	*   ends: 55,                  Last displayed minute
	*   interval: 5                Interval of displayed minutes
	* @property int $Rows Number of rows for the input tables, minimum 2, makes more sense if you use multiple of 2
	* @property bool $ShowHours Define if the hours section is displayed or not. Set to false to get a minute only dialog
	* @property bool $ShowMinutes Define if the minutes section is displayed or not. Set to false to get an hour only dialog
	* @property bool $ShowCloseButton Shows an OK button to confirm the edit
	* @property string $CloseButtonText Text for the confirmation button (ok button)
	* @property bool $ShowNowButton Shows the 'now' button
	* @property string $NowButtonText Text for the now button
	* @property bool $ShowDeselectButton Shows the deselect time button
	* @property string $DeselectButton Text for the deselect button
	*/
	namespace QCubed\Plugin;
	use \QTextBox, \QType, \QApplication, \QInvalidCastException,
		\QCallerException, \QModelConnectorParam, \QJsPriority;
	
	class QTimepickerBoxGen extends QTextBox	{
		/** @var boolean */
		protected $blnDisabled = null;
		/** @var string */
		protected $strButton = null;
		/** @var string */
		protected $strTimeSeperator = null;
		/** @var boolean */
		protected $blnShowPeriod = null;
		/** @var boolean */
		protected $blnShowPeriodLabels = null;
		/** @var boolean */
		protected $blnShowLeadingZero = null;
		/** @var boolean */
		protected $blnShowMinutesLeadingZero = null;
		/** @var string */
		protected $strPeriodSeparator = null;
		/** @var string */
		protected $strAltField = null;
		/** @var string */
		protected $strDefaultTime = null;
		/** @var string */
		protected $strShowOn = null;
		/** @var string */
		protected $strHourText = null;
		/** @var string */
		protected $strMinuteText = null;
		/** @var string */
		protected $strAmPmText = null;
		/** @var string */
		protected $strMyPosition = null;
		/** @var string */
		protected $strAtPosition = null;
		/** @var array */
		protected $mixHoursArray = null;
		/** @var array */
		protected $mixMinutesArray = null;
		/** @var integer */
		protected $intRows = null;
		/** @var boolean */
		protected $blnShowHours = null;
		/** @var boolean */
		protected $blnShowMinutes = null;
		/** @var boolean */
		protected $blnShowCloseButton = null;
		/** @var string */
		protected $strCloseButtonText = null;
		/** @var boolean */
		protected $blnShowNowButton = null;
		/** @var string */
		protected $strNowButtonText = null;
		/** @var boolean */
		protected $blnShowDeselectButton = null;
		/** @var string */
		protected $strDeselectButtonText = null;
		
		/** @var array $custom_events Event Class Name => Event Property Name */
		protected static $custom_events = array(
		);
		
		protected function makeJqOptions() {
			$jqOptions = null;
			if (!is_null($val = $this->Button)) {$jqOptions['button'] = $val;}
			if (!is_null($val = $this->TimeSeperator)) {$jqOptions['timeSeperator'] = $val;}
			if (!is_null($val = $this->ShowPeriod)) {$jqOptions['showPeriod'] = $val;}
			if (!is_null($val = $this->ShowPeriodLabels)) {$jqOptions['showPeriodLabels'] = $val;}
			if (!is_null($val = $this->ShowLeadingZero)) {$jqOptions['showLeadingZero'] = $val;}
			if (!is_null($val = $this->ShowMinutesLeadingZero)) {$jqOptions['showMinutesLeadingZero'] = $val;}
			if (!is_null($val = $this->PeriodSeparator)) {$jqOptions['periodSeparator'] = $val;}
			if (!is_null($val = $this->AltField)) {$jqOptions['altField'] = $val;}
			if (!is_null($val = $this->DefaultTime)) {$jqOptions['defaultTime'] = $val;}
			if (!is_null($val = $this->ShowOn)) {$jqOptions['showOn'] = $val;}
			if (!is_null($val = $this->HourText)) {$jqOptions['hourText'] = $val;}
			if (!is_null($val = $this->MinuteText)) {$jqOptions['minuteText'] = $val;}
			if (!is_null($val = $this->AmPmText)) {$jqOptions['amPmText'] = $val;}
			if (!is_null($val = $this->MyPosition)) {$jqOptions['myPosition'] = $val;}
			if (!is_null($val = $this->AtPosition)) {$jqOptions['atPosition'] = $val;}
			if (!is_null($val = $this->HoursArray)) {$jqOptions['hours'] = $val;}
			if (!is_null($val = $this->MinutesArray)) {$jqOptions['minutes'] = $val;}
			if (!is_null($val = $this->Rows)) {$jqOptions['rows'] = $val;}
			if (!is_null($val = $this->ShowHours)) {$jqOptions['showHours'] = $val;}
			if (!is_null($val = $this->ShowMinutes)) {$jqOptions['showMinutes'] = $val;}
			if (!is_null($val = $this->ShowCloseButton)) {$jqOptions['showCloseButton'] = $val;}
			if (!is_null($val = $this->CloseButtonText)) {$jqOptions['closeButtonText'] = $val;}
			if (!is_null($val = $this->ShowNowButton)) {$jqOptions['showNowButton'] = $val;}
			if (!is_null($val = $this->NowButtonText)) {$jqOptions['nowButtonText'] = $val;}
			if (!is_null($val = $this->ShowDeselectButton)) {$jqOptions['showDeselectButton'] = $val;}
			if (!is_null($val = $this->DeselectButtonText)) {$jqOptions['deselectButtonText'] = $val;}
			return $jqOptions;
		}

		protected function getJqSetupFunction() {
			return 'timepicker';
		}

		public function GetEndScript() {
			$strId = $this->GetJqControlId();
			$jqOptions = $this->makeJqOptions();
			$strFunc = $this->getJqSetupFunction();

			if ($strId !== $this->ControlId && QApplication::$RequestMode == QRequestMode::Ajax) {
				// If events are not attached to the actual object being drawn, then the old events will not get
				// deleted during redraw. We delete the old events here. This must happen before any other event processing code.
				QApplication::ExecuteControlCommand($strId, 'off', QJsPriority::High);
			}

			// Attach the javascript widget to the html object
			if (empty($jqOptions)) {
				QApplication::ExecuteControlCommand($strId, $strFunc, QJsPriority::High);
			} else {
				QApplication::ExecuteControlCommand($strId, $strFunc, $jqOptions, QJsPriority::High);
			}

			return parent::GetEndScript();
		}

		/**
		 * Remove the timepicker functionality completely. This will return the
		 * element back to its pre-init state.
		 */
		public function Destroy() {
			QApplication::ExecuteControlCommand($this->getJqControlId(), $this->getJqSetupFunction(), "destroy", QJsPriority::Low);
		}

		/**
		 * Disable the widget.
		 */
		public function Disable() {
			QApplication::ExecuteControlCommand($this->getJqControlId(), $this->getJqSetupFunction(), "disable", QJsPriority::Low);
		}

		/**
		 * Enable the widget.
		 */
		public function Enable() {
			QApplication::ExecuteControlCommand($this->getJqControlId(), $this->getJqSetupFunction(), "enable", QJsPriority::Low);
		}

		/**
		 * Get or set any widget option.
		 * @param $optionName
		 * @param $value
		 */
		public function Option($optionName, $value) {
			QApplication::ExecuteControlCommand($this->getJqControlId(), $this->getJqSetupFunction(), "option", $optionName, $value, QJsPriority::Low);
		}

		/**
		 * Set multiple options at once by providing an options object.
		 * @param $options
		 */
		public function Options($options) {
			QApplication::ExecuteControlCommand($this->getJqControlId(), $this->getJqSetupFunction(), "option", $options, QJsPriority::Low);
		}

		public function __get($strName) {
			switch ($strName) {
				case 'Button': return $this->strButton;
				case 'TimeSeperator': return $this->strTimeSeperator;
				case 'ShowPeriod': return $this->blnShowPeriod;
				case 'ShowPeriodLabels': return $this->blnShowPeriodLabels;
				case 'ShowLeadingZero': return $this->blnShowLeadingZero;
				case 'ShowMinutesLeadingZero': return $this->blnShowMinutesLeadingZero;
				case 'PeriodSeparator': return $this->strPeriodSeparator;
				case 'AltField': return $this->strAltField;
				case 'DefaultTime': return $this->strDefaultTime;
				case 'ShowOn': return $this->strShowOn;
				case 'HourText': return $this->strHourText;
				case 'MinuteText': return $this->strMinuteText;
				case 'AmPmText': return $this->strAmPmText;
				case 'MyPosition': return $this->strMyPosition;
				case 'AtPosition': return $this->strAtPosition;
				case 'HoursArray': return $this->mixHoursArray;
				case 'MinutesArray': return $this->mixMinutesArray;
				case 'Rows': return $this->intRows;
				case 'ShowHours': return $this->blnShowHours;
				case 'ShowMinutes': return $this->blnShowMinutes;
				case 'ShowCloseButton': return $this->blnShowCloseButton;
				case 'CloseButtonText': return $this->strCloseButtonText;
				case 'ShowNowButton': return $this->blnShowNowButton;
				case 'NowButtonText': return $this->strNowButtonText;
				case 'ShowDeselectButton': return $this->blnShowDeselectButton;
				case 'DeselectButtonText': return $this->strDeselectButtonText;
				default: 
					try { 
						return parent::__get($strName); 
					} catch (QCallerException $objExc) { 
						$objExc->IncrementOffset(); 
						throw $objExc; 
					}
			}
		}

		public function __set($strName, $mixValue) {
			switch ($strName) {
				case 'Button':
					try {
						$this->strButton = QType::Cast($mixValue, QType::String);
						$this->AddAttributeScript($this->getJqSetupFunction(), 'option', 'button', $this->strButton);
						break;
					} catch (QInvalidCastException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}

				case 'TimeSeperator':
					try {
						$this->strTimeSeperator = QType::Cast($mixValue, QType::String);
						$this->AddAttributeScript($this->getJqSetupFunction(), 'option', 'timeSeperator', $this->strTimeSeperator);
						break;
					} catch (QInvalidCastException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}
					
				case 'ShowPeriod':
					try {
						$this->blnShowPeriod = QType::Cast($mixValue, QType::Boolean);
						$this->AddAttributeScript($this->getJqSetupFunction(), 'option', 'showPeriod', $this->blnShowPeriod);
						break;
					} catch (QInvalidCastException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}
					
				case 'ShowPeriodLabels':
					try {
						$this->blnShowPeriodLabels = QType::Cast($mixValue, QType::Boolean);
						$this->AddAttributeScript($this->getJqSetupFunction(), 'option', 'showPeriodLabels', $this->blnShowPeriodLabels);
						break;
					} catch (QInvalidCastException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}
					
				case 'ShowLeadingZero':
					try {
						$this->blnShowLeadingZero = QType::Cast($mixValue, QType::Boolean);
						$this->AddAttributeScript($this->getJqSetupFunction(), 'option', 'showLeadingZero', $this->blnShowLeadingZero);
						break;
					} catch (QInvalidCastException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}
					
				case 'ShowMinutesLeadingZero':
					try {
						$this->blnShowMinutesLeadingZero = QType::Cast($mixValue, QType::Boolean);
						$this->AddAttributeScript($this->getJqSetupFunction(), 'option', 'showMinutesLeadingZero', $this->blnShowMinutesLeadingZero);
						break;
					} catch (QInvalidCastException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}
				case 'PeriodSeparator': 					
					try {
						$this->strPeriodSeparator = QType::Cast($mixValue, QType::String);
						$this->AddAttributeScript($this->getJqSetupFunction(), 'option', 'periodSeparator', $this->strPeriodSeparator);
						break;
					} catch (QInvalidCastException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}
				case 'AltField': 
					try {
						$this->strAltField = QType::Cast($mixValue, QType::String);
						$this->AddAttributeScript($this->getJqSetupFunction(), 'option', 'altField', $this->strAltField);
						break;
					} catch (QInvalidCastException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}
				case 'DefaultTime':
					try {
						$this->strDefaultTime = QType::Cast($mixValue, QType::String);
						$this->AddAttributeScript($this->getJqSetupFunction(), 'option', 'defaultTime', $this->strDefaultTime);
						break;
					} catch (QInvalidCastException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}

				case 'ShowOn': 
					try {
						$this->strShowOn = QType::Cast($mixValue, QType::String);
						$this->AddAttributeScript($this->getJqSetupFunction(), 'option', 'showOn', $this->strShowOn);
						break;
					} catch (QInvalidCastException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}

				case 'HourText': 
					try {
						$this->strHourText = QType::Cast($mixValue, QType::String);
						$this->AddAttributeScript($this->getJqSetupFunction(), 'option', 'hourText', $this->strHourText);
						break;
					} catch (QInvalidCastException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}

				case 'MinuteText': 
					try {
						$this->strMinuteText = QType::Cast($mixValue, QType::String);
						$this->AddAttributeScript($this->getJqSetupFunction(), 'option', 'minuteText', $this->strMinuteText);
						break;
					} catch (QInvalidCastException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}

				case 'AmPmText': 
					try {
						$this->strAmPmText = QType::Cast($mixValue, QType::String);
						$this->AddAttributeScript($this->getJqSetupFunction(), 'option', 'amPmText', $this->strAmPmText);
						break;
					} catch (QInvalidCastException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}

				case 'MyPosition': 
					try {
						$this->strMyPosition = QType::Cast($mixValue, QType::String);
						$this->AddAttributeScript($this->getJqSetupFunction(), 'option', 'myPosition', $this->strMyPosition);
						break;
					} catch (QInvalidCastException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}

				case 'AtPosition': 
					try {
						$this->strAtPosition = QType::Cast($mixValue, QType::String);
						$this->AddAttributeScript($this->getJqSetupFunction(), 'option', 'atPosition', $this->strAtPosition);
						break;
					} catch (QInvalidCastException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}

				case 'HoursArray': 
					try {
						$this->mixHoursArray = QType::Cast($mixValue, QType::ArrayType);
						$this->AddAttributeScript($this->getJqSetupFunction(), 'option', 'hours', $this->mixHoursArray);
						break;
					} catch (QInvalidCastException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}

				case 'MinutesArray': 
					try {
						$this->mixMinutesArray = QType::Cast($mixValue, QType::ArrayType);
						$this->AddAttributeScript($this->getJqSetupFunction(), 'option', 'minutes', $this->mixMinutesArray);
						break;
					} catch (QInvalidCastException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}

				case 'Rows': 
					try {
						$this->intRows = QType::Cast($mixValue, QType::Integer);
						$this->AddAttributeScript($this->getJqSetupFunction(), 'option', 'rows', $this->intRows);
						break;
					} catch (QInvalidCastException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}

				case 'ShowHours': 
					try {
						$this->blnShowHours = QType::Cast($mixValue, QType::Boolean);
						$this->AddAttributeScript($this->getJqSetupFunction(), 'option', 'showHours', $this->blnShowHours);
						break;
					} catch (QInvalidCastException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}

				case 'ShowMinutes': 
					try {
						$this->blnShowMinutes = QType::Cast($mixValue, QType::Boolean);
						$this->AddAttributeScript($this->getJqSetupFunction(), 'option', 'showMinutes', $this->blnShowMinutes);
						break;
					} catch (QInvalidCastException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}

				case 'ShowCloseButton': 
					try {
						$this->blnShowCloseButton = QType::Cast($mixValue, QType::Boolean);
						$this->AddAttributeScript($this->getJqSetupFunction(), 'option', 'showCloseButton', $this->blnShowCloseButton);
						break;
					} catch (QInvalidCastException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}

				case 'CloseButtonText': 
					try {
						$this->strCloseButtonText = QType::Cast($mixValue, QType::String);
						$this->AddAttributeScript($this->getJqSetupFunction(), 'option', 'closeButtonText', $this->strCloseButtonText);
						break;
					} catch (QInvalidCastException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}

				case 'ShowNowButton': 
					try {
						$this->blnShowNowButton = QType::Cast($mixValue, QType::Boolean);
						$this->AddAttributeScript($this->getJqSetupFunction(), 'option', 'showNowButton', $this->blnShowNowButton);
						break;
					} catch (QInvalidCastException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}

				case 'NowButtonText': 
					try {
						$this->strNowButtonText = QType::Cast($mixValue, QType::String);
						$this->AddAttributeScript($this->getJqSetupFunction(), 'option', 'nowButtonText', $this->strNowButtonText);
						break;
					} catch (QInvalidCastException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}

				case 'ShowDeselectButton': 
					try {
						$this->blnShowDeselectButton = QType::Cast($mixValue, QType::Boolean);
						$this->AddAttributeScript($this->getJqSetupFunction(), 'option', 'showDeselectButton', $this->blnShowDeselectButton);
						break;
					} catch (QInvalidCastException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}

				case 'DeselectButtonText': 
					try {
						$this->strDeselectButtonText = QType::Cast($mixValue, QType::String);
						$this->AddAttributeScript($this->getJqSetupFunction(), 'option', 'deselectButtonText', $this->strDeselectButtonText);
						break;
					} catch (QInvalidCastException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}
					
				default:
					try {
						parent::__set($strName, $mixValue);
						break;
					} catch (QCallerException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}
			}
		}

		/**
		 * Get an array of QModelConnectorParam types to use for displaying options in the ModelConnector dialog.
		 * @return \QModelConnectorParam[]
		 */
		public static function GetModelConnectorParams() {
			return array_merge(parent::GetModelConnectorParams(), array(
				new QModelConnectorParam (get_called_class(), 'Button', 'Name of the button to popup the control. Default: none', QType::String),
				new QModelConnectorParam (get_called_class(), 'TimeSeparator', 'The character to use to separate hours and minutes. Default: : (colon)', QType::String),
				new QModelConnectorParam (get_called_class(), 'ShowPeriod', 'Whether to display the period. Default: true', QType::Boolean),
				new QModelConnectorParam (get_called_class(), 'ShowPeriodLabels', 'Whether to display the period labels. Default: true', QType::Boolean),
				new QModelConnectorParam (get_called_class(), 'ShowLeadingZero', 'Whether to display leading zeros in the hour numbers. Default: true', QType::Boolean),
				new QModelConnectorParam (get_called_class(), 'ShowMinutesLeadingZero', 'Whether to display leading zeros in the minutes numbers. Default: true', QType::Boolean),
				new QModelConnectorParam (get_called_class(), 'PeriodSeparator', 'What character to use to separate the periods. Default: (space)', QType::String),
				new QModelConnectorParam (get_called_class(), 'AltField', 'Selector for an alternate field to store the time into. Default: none', QType::String),
				new QModelConnectorParam (get_called_class(), 'DefaultTime', 'The default time value. Default: now. Default: now', QType::String),
				new QModelConnectorParam (get_called_class(), 'ShowOn', 'Whether to show on focus, or wait for a button click. Default: focus', QType::ArrayType, ['Focus'=>'focus', 'Button'=>'button']),
				new QModelConnectorParam (get_called_class(), 'HourText', 'Text to use for the hour label. Default: Hour', QType::String),
				new QModelConnectorParam (get_called_class(), 'MinuteText', 'Text to use for the minute label. Default: Minute', QType::String),
				new QModelConnectorParam (get_called_class(), 'AmPmText', 'Text to use to display Am and Pm. Must be separated by commas, as in "AM, PM"', QType::ArrayType),
				new QModelConnectorParam (get_called_class(), 'MyPosition', 'Position of the dialog relative to the input. Defaults to "left top"', QType::String),
				new QModelConnectorParam (get_called_class(), 'AtPosition', 'Position of the element to attach to. Defaults to "left bottom"', QType::String),
				new QModelConnectorParam (get_called_class(), 'HoursArray', 'First and last displayed hours', QType::String),
				new QModelConnectorParam (get_called_class(), 'MinutesArray', 'Start, end and interval', QType::String),
				new QModelConnectorParam (get_called_class(), 'Rows', 'Number of rows to display', QType::Integer),
				new QModelConnectorParam (get_called_class(), 'ShowHours', 'False to hide the hours display', QType::Boolean),
				new QModelConnectorParam (get_called_class(), 'ShowMinutes', 'False to hide the minutes display.', QType::Integer),
				new QModelConnectorParam (get_called_class(), 'ShowCloseButton', 'False to hide the close button', QType::Boolean),
				new QModelConnectorParam (get_called_class(), 'CloseButtonText', 'Text to display on the close button', QType::String),
				new QModelConnectorParam (get_called_class(), 'ShowNowButton', 'True to display the Now button', QType::Boolean),
				new QModelConnectorParam (get_called_class(), 'NowButtonText', 'Text to display on the now button', QType::String),
				new QModelConnectorParam (get_called_class(), 'ShowDeselectButton', 'True to show the deselect button', QType::Boolean),
				new QModelConnectorParam (get_called_class(), 'DeselectButtonText', 'Text to display on the deselect button', QType::String)
			));
		}

	}

?>
