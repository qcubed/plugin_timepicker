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

class QDateTimePickerBox extends QControl {

	public $datePicker;
	public $timePicker;

	public function __construct($objParentObject, $strControlId = null) {
		try {
			parent::__construct($objParentObject, $strControlId);
		} catch (QCallerException $objExc) {
			$objExc->IncrementOffset();
			throw $objExc;
		}

		$this->datePicker = new QDatepickerBox($this);
		$this->datePicker->Columns = 10;
		$this->timePicker = new QTimepickerBox($this);
		$this->timePicker->Columns = 8;
	}

	public function ParsePostData() {
		$this->datePicker->ParsePostData();
		$this->timePicker->ParsePostData();
	}

	/**
	 * Pass off validation to individual controls.
	 *
	 * @return bool
	 */
	public function Validate() {
		$blnValid1 = $this->datePicker->Validate();
		$blnValid2 = $this->timePicker->Validate();

		$blnValid = ($blnValid1 && $blnValid2);

		if (!$blnValid) {
			$this->ValidationError = $this->datePicker->ValidationError . ' ' . $this->timePicker->ValidationError;
		}
		return $blnValid;
	}

	/**
	 * Return the combined control html.
	 *
	 * @return string
	 */
	protected function GetControlHtml() {
		// Lets get Style attributes
		$strDate = $this->datePicker->Render(false);
		$strTime = $this->timePicker->Render(false);

		return QHtml::RenderTag('span', $this->GetHtmlAttributes(), $strDate . $strTime);

	}

	/**
	 * Return the
	 * @return null|QDateTime
	 */
	public function GetDateTime() {
		$date = $this->datePicker->DateTime;
		$time = $this->timePicker->DateTime;

		if ($date === null) {
			return null; // can't have a time without a date
		}

		$ret = new QDateTime($date, null, QDateTime::DateAndTimeType);

		if ($time) {
			$ret->AddMinutes($time->Hour * 60 + $time->Minute);
			/**
			 * The next line is required if the date is a dst boundary date. In this situation, just setting the time will
			 * not advance the timezone setting. By using AddMinutes instead, the timezone setting will advance, but then
			 * the time will be moved back an hour. So, we need to do both adding time, and then setting the hour to make
			 * sure the time is correct. Again, we need this because if the date coming out of the datePicker is on a dst
			 * boundary, it will have a zero time, so that will be before the change in time. Most times will fall after that
			 * boundary.
			 */

			$ret->Hour = $time->Hour;
		} else {
			$ret->setTime(null);
		}
		return $ret;
	}

	// And our public getter/setters
	public function __get($strName) {
		switch ($strName) {
			case 'DateTime' : return $this->GetDateTime();
			case 'DatePicker': return $this->datePicker;
			case 'TimePicker': return $this->timePicker;
			default:
				try {
					return parent::__get($strName);
				} catch (QCallerException $objExc) {
					$objExc->IncrementOffset();
					throw $objExc;
				}
		}
	}

	/**
	 * To set parameters on the date or time picker, set those directly on the public objects.
	 *
	 * @param string $strName
	 * @param string $mixValue
	 * @return mixed|void
	 * @throws Exception
	 * @throws QCallerException
	 */
	public function __set($strName, $mixValue) {
		try {
			switch ($strName) {
				case 'DateTime' :
					$dtt = QType::Cast($mixValue, QType::DateTime);
					if ($dtt === null) {
						$this->datePicker->DateTime = null;
						$this->timePicker->DateTime = null;
					} else {
						$dtt2 = new QDateTime($dtt, null, QDateTime::DateOnlyType);
						$dtt3 = new QDateTime($dtt, null, QDateTime::TimeOnlyType);
						$this->datePicker->DateTime = $dtt2;
						$this->timePicker->DateTime = $dtt3;
					}
					return $dtt;

				case 'Required' :
					$this->blnRequired = QType::Cast($mixValue, QType::Boolean);
					$this->datePicker->Required = $mixValue;
					$this->timePicker->Required = $mixValue;
					return $this->blnRequired;
					break;

				default:
					return (parent::__set($strName, $mixValue));
			}
		} catch (QCallerException $objExc) {
			$objExc->IncrementOffset();
			throw $objExc;
		}
	}

	public static function GetCodeGenerator () {
		return new QDateTimePickerBox_CodeGenerator(get_class());
	}


}
?>
