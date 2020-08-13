<?php
/* 
    返回错误信息文件上传类
*/
class Upload {
    private $fileName;
    private $formName;
    private $maxSize;
    private $ext;
    public $newFileName;	//上传文件新文件名
    public $oldFileName;	//文件上传之前文件名
    public $getError;		//上传文件错误信息
	
	
    /* 
    * param $formName 表单名称
    * param $path 上传路径
    * param $maxSize 上传最大文件大小
    */
	function __construct( $formName, $path = './upload', $maxSize='10000000' ){
        $this->maxSize = $maxSize;
        $this->formName = $formName;
        $this->oldFileName = $_FILES[$this->formName]['name'];
		$this->ext = pathinfo($_FILES[$this->formName]['name'], PATHINFO_EXTENSION);
		$this->newFileName = date('YmdHis').uniqid().rand().'.'.$this->ext;
        
		if (!$this->error()){
            return false;
		}
		if (!$this->size()){
            return false;
		}
		// if (!$this->type()){
            // return false;
		// }
		if($this->remove($path)){
            return true;
        }else{
            return false;
        }
    }
	
	
    /*
	* 检查错误
	*/
    private function error()
	{
        if( $_FILES[$this->formName]['error'] > 0 ){
            switch($_FILES[$this->formName]['error']){
                case 1:
                    $this->getError = '超过配置文件中预设的最大值';
                    break;
                case 2:
                    $this->getError = '超过了表单中预设的最大值';
                    break;
                case 3:
                    $this->getError = '文件部分被上传';
                    break;
                case 4:
                    $this->getError = '没有文件被上传';
                    break;
                case 6:
                    $this->getError = '找不到临时文件夹';
                    break;
                case 7:
                    $this->getError = '文件写入失败';
                    break;
                default:
                    $this->getError = '未知错误';
            }
            return false;
        }else{
            return true;
        }
    }
	
	
    /*
	* 限制大小
	*/
    private function size()
	{
        if($_FILES[$this->formName]['size'] > $this->maxSize){
            return $this->getError = "上传文件超过了{$this->maxSize}";
        }
        return true;
    }
	
	
    /*
	* 限制类型
	*/
    private function type()
	{
        $types = array('jpg', 'jpeg', 'gif', 'png', 'bmp', 'txt', 'json');
        if(!in_array(strtolower($this->ext), $types)){
            return $this->getError = "上传文件类型不支持";
        }
        return true;
    }
	
	
    /*
	* 移动文件
	* param $newPath string 将文件移动到的新路径
	*/
    private function remove($newPath)
	{
        $newPath = rtrim($newPath,'/');
        if(is_uploaded_file($_FILES[$this->formName]['tmp_name'])){
            if(move_uploaded_file($_FILES[$this->formName]['tmp_name'], $newPath.'/'.$this->newFileName)){
                return true;
            }
        }else{
            $this->getError = '上传错误';
            return false;
        }
    }
	
}