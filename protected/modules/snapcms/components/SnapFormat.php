<?php
class SnapFormat
{
	//http://stackoverflow.com/questions/2955251/php-function-to-make-slug-url-string
	static public function slugify($text)
	{ 
		// replace non letter or digits by -
		
		$text = preg_replace('~[^\\pL\d\/]+~u', '-', $text);
		//echo $text.'<br />';
		// trim
		$text = trim($text, '-');
		// transliterate
		$text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
		// lowercase
		$text = strtolower($text);
		
		
		
		// remove unwanted characters
		$text = preg_replace('~[^-\w\/]+~', '', $text);
		if (empty($text))
		{
			return 'n-a';
		}
		return $text;
	}
	
	/**
	 * 
	 * @param type $date
	 * @param string $dateWidth 'full', 'long', 'medium', 'short'
	 * @return type
	 */
	static public function date($date,$dateWidth='medium',$timeWidth='short')
	{
		return Yii::app()->dateFormatter->formatDateTime($date,$dateWidth,$timeWidth);
	}
}