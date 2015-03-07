<?php
Yii::import('vendor.ckeditorwidget.TheCKEditorWidget');
class SnapCKEditorWidget extends TheCKEditorWidget
{
    private $_ckeditorUrl;
    private $_kcfinderUrl;
    
    public function init()
    {
        $this->_ckeditorUrl = Yii::app()->assetManager->publish(Yii::getPathOfAlias('vendor.ckeditor.ckeditor'));
        $this->_kcfinderUrl = Yii::app()->assetManager->publish(Yii::getPathOfAlias('vendor.kcfinder'));
        $this->ckBasePath = $this->_ckeditorUrl.'/';
        
        $this->config = $this->config ? $this->config : array();
        $this->config = array_merge(array(
            'filebrowserBrowseUrl'      => $this->_kcfinderUrl . '/browse.php?type=files',
            'filebrowserImageBrowseUrl' => $this->_kcfinderUrl . '/browse.php?type=images',
            'filebrowserFlashBrowseUrl' => $this->_kcfinderUrl . '/browse.php?type=flash',
            'filebrowserUploadUrl'      => $this->_kcfinderUrl . '/upload.php?type=files',
            'filebrowserImageUploadUrl' => $this->_kcfinderUrl . '/upload.php?type=images',
            'filebrowserFlashUploadUrl' => $this->_kcfinderUrl . '/upload.php?type=flash'
        ), $this->config);        
    }
}
