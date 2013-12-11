<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	public function authenticate()
	{
		$user = User::model()->findByAttributes(array('email' => $this->username));

		if ($user === null) {
			$this->errorCode = self::ERROR_USERNAME_INVALID;
		} else if ($user->password !== self::doHash($this->password)) {
			$this->errorCode = self::ERROR_PASSWORD_INVALID;
		} else { // Okay!
			$this->errorCode = self::ERROR_NONE;
			self::setState('username', $user->email);
			self::setState('first_name', $user->first_name);
			self::setState('last_name', $user->last_name);
			self::setState('full_name', $user->full_name);
			self::setState('id', $user->id);
			//TODO: Work out why CWebUser::getId() in CWebUser::checkAccess returns the email address (username?) 
			//Not sure why I have to do this?? it's changed to 
			self::setState('__id', $user->id);
		}
		return !$this->errorCode;
	}
	
	public static function doHash($password)
	{
		$conf = SnapUtil::getConfig('general');
		$salt = $conf['security']['salt'];
		$hash = hash('sha256',$password.$salt);
		return $hash;
	}
}