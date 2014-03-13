<?php
class SnapFormat
{
	//http://stackoverflow.com/questions/2955251/php-function-to-make-slug-url-string
	public static function slugify($text)
	{ 
		$text = preg_replace('~[^\\pL\d\/]+~u', '-', $text);
		$text = trim($text, '-');
		$text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
		$text = strtolower($text);

		// remove unwanted characters
		$text = preg_replace('~[^-\w\/]+~', '', $text);
		if (empty($text))
		{
			return '';
		}
		return $text;
	}
	
	/**
	 * 
	 * @param type $date
	 * @param string $dateWidth 'full', 'long', 'medium', 'short'
	 * @return type
	 */
	static public function date($date,$dateWidth='medium',$timeWidth=false)
	{
		return Yii::app()->dateFormatter->formatDateTime($date,$dateWidth,$timeWidth);
	}
	
	static public function time($date,$dateWidth=false,$timeWidth='short')
	{
		return Yii::app()->dateFormatter->formatDateTime($date,$dateWidth,$timeWidth);
	}
	
	static public function datetime($date,$dateWidth='medium',$timeWidth='short')
	{
		return Yii::app()->dateFormatter->formatDateTime($date,$dateWidth,$timeWidth);
	}
	
	public static function currency($value)
	{
		$cn=new CNumberFormatter(Yii::app()->locale->id);
		return $cn->formatCurrency($value,'USD');
	}
}