<?php
class SnapJSONResponse extends CComponent
{
	const STATUS_UNKNOWN_ERROR = 0;
	const STATUS_SUCCESS = 1;
	
	const STATUS_ERROR_SAVE = 101;

	public $status;
	protected $flashWrapperId = 'flashes';
	protected $message;
	protected $updateContent = array();
	protected $loadFlashMessages = true;
	
	public function __construct($properties=array())
	{
		foreach($properties as $name=>$value)
			$this->$name=$value;
	}
	
	public function getResponse()
	{
		$return = array (
			'status'=>$this->status,
			'message'=>$this->messageText,
			'updateContent'=>$this->updateContent,
		);
		
		if($this->loadFlashMessages) {
			$return['updateContent'][$this->flashWrapperId] = Yii::app()->controller->renderPartial('../layouts/_flash_messages',null,true);
		}

		return json_encode($return);
	}
	
	public function getDefaultErrorMessages()
	{
		return array (
			self::STATUS_UNKNOWN_ERROR => 'Unknown Error',
			self::STATUS_SUCCESS => 'Success',
			self::STATUS_ERROR_SAVE => 'There was an error saving to the databse.',
		);
	}
	
	public function getMessageText()
	{
		if($this->message !== null)
			return $this->message;
		
		$errors = $this->getDefaultErrorMessages();
		if(isset($errors[$this->status])) {
			return $errors[$this->status];
		} else {
			return 'Unkown Error';
		}
	}
}