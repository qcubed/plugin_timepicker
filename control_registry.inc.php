<?php

/**
 * Called by the MetaControl Designer to create a list of controls appropriate for the given database field type.
 * The control will  be available in the list of controls that appear in the metacontrol desginer dialog
 * in the ControlClass entry.
 */

//$controls[QDatabaseFieldType::VarChar][] = '';
//$controls[QDatabaseFieldType::Blob][] = '';
//$controls[QDatabaseFieldType::Char][] = '';
//$controls[QDatabaseFieldType::Integer][] = '';
//$controls[QDatabaseFieldType::Float][] = '';
//$controls[QDatabaseFieldType::Bit][] = '';
$controls[QDatabaseFieldType::DateTime][] = 'QCubed\Plugin\QDateTimePickerBox';
//$controls[QDatabaseFieldType::Date][] = '';
$controls[QDatabaseFieldType::Time][] = 'QCubed\Plugin\QTimepickerBox';
//$controls[QType::ArrayType][] = ''; // Many-to-one. Includes forward and unique reverse references.
//$controls[QType::Association][] = ''; // Many-to-many.

?>