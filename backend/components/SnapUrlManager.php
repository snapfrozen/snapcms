<?php
class SnapUrlManager extends CUrlManager
{
    public function createUrl($route, $params = array(), $ampersand = '&')
    {
        $route = preg_replace_callback('/(?<![A-Z])[A-Z]/', function($matches) {
            return '-' . lcfirst($matches[0]);
        }, $route);
		
		//Francis - This feels very hacky, it would be good to find a cleaner
		//way of doing this.
		if(strpos($route, 'content/view') !== false && isset($params['path'])) 
		{
			$path = $params['path'];
			unset($params['path']);
			//Add on any extra parameters to the get string (fixes pagination)
			if(!empty($params)) {
				$path .= '?' . http_build_query($params);
			}
			return Yii::app()->baseUrl .  $path;
		}
		
        return parent::createUrl($route, $params, $ampersand);
    }
 
    public function parseUrl($request)
    {
		$path='/'.$request->pathInfo;
		if(!empty($path))
			$MI=MenuItem::model()->findByAttributes(array('path'=>$path));
		
		if($MI && $MI->content_id) {
			$route='content/view/id/'.$MI->content_id;
			$_GET['path']=$MI->path; //So that menu items become active
		} else if($MI && $MI->external_path) {
			//$route = parent::parseUrl($request);
			Yii::app()->getRequest()->redirect($MI->external_path,true,302);
		} else {
			$route = parent::parseUrl($request);
		}
        return lcfirst(str_replace(' ', '', ucwords(str_replace('-', ' ', $route))));
    }
}
