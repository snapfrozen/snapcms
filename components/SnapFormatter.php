<?php
/**
 * SnapFormatter class file.
 *
 * @author Francis Beresford <francis.beresford@gmail.com>
 * @license http://opensource.org/licenses/MIT
 */
class SnapFormatter extends CFormatter
{
	/**
	 * Formats the value as a date.
	 * @param mixed $value the value to be formatted
	 * @return string the formatted result
	 * @see dateFormat
	 */
	public function formatDate($value) 
	{
		return SnapFormat::date($this->normalizeDateValue($value));
	}
	
	public function formatTime($value) 
	{
		return SnapFormat::time($this->normalizeDateValue($value));
	}
	
	public function formatDatetime($value) 
	{
		return SnapFormat::datetime($this->normalizeDateValue($value));
	}
	
	public function formatCurrency($value)
	{
		return SnapFormat::currency($value);
	}

	public function formatWithPercentSymbol($value)
	{
		return sprintf('%.2f%%',$value);
	}
}