<?php

class SnapUtil {

    protected static $_colMapName = array(
        'currency' => array('price'),
        'html' => array('content'),
    );
    protected static $_configCache = array();

    public function createUrl($route, $params = array(), $ampersand = '&') {
        $route = preg_replace_callback('/(?<![A-Z])[A-Z]/', function($matches) {
            return '-' . lcfirst($matches[0]);
        }, $route);
        return parent::createUrl($route, $params, $ampersand);
    }

    public function parseUrl($request) {
        $path = '/' . Yii::app()->request->pathInfo;
        $MI = MenuItem::model()->findByAttributes(array('path' => $path));
        if ($MI && $MI->content_id) {
            $route = 'content/view/id/' . $MI->content_id;
        } else {
            $route = parent::parseUrl($request);
        }
        return lcfirst(str_replace(' ', '', ucwords(str_replace('-', ' ', $route))));
    }

    /**
     * Returns a config value found in config
     * @param string $path Yii style path representation of a config file
     * @return array the config array for the chosen file
     */
    public static function getConfig($path) {
        $confPath = Yii::getPathOfAlias('frontend.config.snapcms.' . $path);
        return require($confPath . '.php');
    }

    /**
     * Returns a config value defined by path in the format "path.to.config.file/location.in.array"
     * e.g. "general/site.homepage_id"
     * @param string $fullPath
     * @return string The value found in the config file/database table
     */
    public static function config($fullPath) {
        if (isset(self::$_configCache[$fullPath])) {
            return self::$_configCache[$fullPath];
        }

        $Config = Config::model()->findByPk($fullPath);
        if ($Config) {
            self::$_configCache[$fullPath] = $Config->value;
            return $Config->value;
        }

        list($filePath, $confLoc) = explode('/', $fullPath);
        $conf = self::getConfig($filePath);

        $locParts = explode('.', $confLoc);
        foreach ($locParts as $part) {
            if (!isset($conf[$part]))
                throw new CException("Configuration not found: $fullPath");
            $conf = $conf[$part];
        }

        self::$_configCache[$fullPath] = $conf;
        return $conf;
    }

    /**
     * Returns a slated and hashed string
     * @param string $password The password you wish to hash
     * @return string A hashed and salted tstring
     */
    public static function doHash($password) {
        $conf = SnapUtil::getConfig('general');
        $salt = $conf['security']['salt'];
        $hash = hash('sha256', $password . $salt);
        return $hash;
    }

    public static function getColumnAndFormatter($model, $attribute) {
        $validators = $model->getValidators($attribute);
        $output = false;

        foreach ($validators as $validator) {
            if ($validator instanceof CDateValidator) {
                if ($validator->format == 'yyyy-MM-dd')
                    $output = $attribute . ":date";
                if ($validator->format == 'hh:mm:ss')
                    $output = $attribute . ":time";
                if ($validator->format == 'yyyy-MM-dd hh:mm:ss')
                    $output = $attribute . ":datetime";
            } else if ($validator instanceof CBooleanValidator) {
                $output = $attribute . ":boolean";
            } else if ($validator instanceof CEmailValidator) {
                $output = $attribute . ":email";
            } else if ($validator instanceof CNumberValidator) {
                $output = $attribute . ":number";
            } else if ($validator instanceof CUrlValidator) {
                $output = $attribute . ":url";
            }
        }

        if (!$output) {
            //Guess format by column name
            foreach (self::$_colMapName as $formatter => $patterns) {
                foreach ($patterns as $pattern) {
                    if (strpos($attribute, $pattern) !== false) {
                        $output = $attribute . ":$formatter";
                        break;
                    }
                }
            }
        }

        if (!$output)
            $output = $attribute . "";

        return $output;
    }

    /**
     * Create an associative array of a set of models
     * @param array $models a list of model objects.
     * @param mixed a comma separated string of fields or an array of fields
     */
    public static function makeArray($models, $fields = null, $key = false) {
        $arrayData = array();

        if ($fields && !is_array($fields)) {
            $fields = explode(',', $fields);
        }

        if ($fields === null) {
            foreach ($models as $model) {
                if (!$key)
                    $arrayData[$model->getPrimaryKey()] = $model->attributes;
                else {
                    $keyValue = self::value($model, $key);
                    $arrayData[$keyValue] = $model->attributes;
                }
            }
        } else {
            foreach ($models as $model) {
                foreach ($fields as $field) {
                    $value = self::value($model, $field);
                    if (!$key) {
                        $keyValue = self::value($model, $key);
                        $arrayData[$keyValue] = $model->attributes;
                    } else {
                        $arrayData[$model->getPrimaryKey()][$field] = $value;
                    }
                }
            }
        }

        return $arrayData;
    }

}
