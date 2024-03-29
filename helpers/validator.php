<?php 
class Validator{

    private $imageError = null;
    private $imageName = null;
    
	public function getImageName()
	{
		return $this->imageName;
	}
	public function getImageError()
	{
		switch ($this->imageError) {
			case 1:
				$error = 'El tipo de la imagen debe ser gif, jpg o png';
				break;
			case 2:
				$error = 'La dimensión de la imagen es incorrecta';
				break;
			case 3:
				$error = 'El tamaño de la imagen debe ser menor a 2MB';
				break;
			case 4:
				$error = 'El archivo de la imagen no existe';
				break;
			default:
				$error = 'Ocurrió un problema con la imagen';
		}
		return $error;
	}
	public function validateMoney($value)
	{
		if (preg_match('/^[0-9]+(?:\.[0-9]{1,2})?$/', $value)) {
			return true;
		} else {
			return false;
		}
	}
	function isHTML($string){
		return $string != strip_tags($string) ? true:false;
	}
  public function validateForm($fields)
	{
		foreach ($fields as $index => $value) {
			$value = trim($value);
			$fields[$index] = $value;
		}
		return $fields;
	}
	public function validateId($value)
	{
		if (filter_var($value, FILTER_VALIDATE_INT, array('min_range' => 1))) {
			return true;
		} else {
			return false;
		}
	}
	public function validateImageFile($file, $path, $name, $maxWidth, $maxHeigth)
	{
		if ($file) {
	     	if ($file['size'] <= 2097152) {
		    	list($width, $height, $type) = getimagesize($file['tmp_name']);
				if ($width <= $maxWidth && $height <= $maxHeigth) {
					//Tipos de imagen: 1 - GIF, 2 - JPG y 3 - PNG
					if ($type == 1 || $type == 2 || $type == 3) {
						if ($name) {
							if (file_exists($path.$name)) {
								$extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
								$this->imageName = uniqid().'.'.$extension;
								return true;
							} else {
								$this->imageError = 4;
								return false;
							}
						} else {
							$extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
							$this->imageName = uniqid().'.'.$extension;
							return true;
						}
					} else {
						$this->imageError = 1;
						return false;
					}
				} else {
					$this->imageError = 2;
					return false;
				}
	     	} else {
				$this->imageError = 3;
				return false;
	     	}
		} else {
			if (file_exists($path.$name)) {
				$this->imageName = $name;
				return true;
			} else {
				$this->imageError = 4;
				return false;
			}
		}
	}
	public function saveFile($file, $path, $name)
    {
		if (file_exists($path)) {
			if (move_uploaded_file($file['tmp_name'], $path.$name)) {
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
	  
	public function deleteFile($path, $name)
    {
		if (file_exists($path)) {
			if (unlink($path.$name)) {
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
	public function validateEmail($email)
	{
		if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
			return true;
		} else {
			return false;
		}
	}
	public function validateAlphabetic($value, $minimum, $maximum)
	{
		if (preg_match('/^[a-zA-ZñÑáÁéÉíÍóÓúÚ\s]{'.$minimum.','.$maximum.'}$/', $value)) {
			return true;
		} else {
			return false;
		}
	}
	public function ValidateInt($value){
		if(preg_match('/^\d+$/', $value)){
			return true;	
		} 
		else {
			return false;
		}
	}
	public function validateAlphanumeric($value, $minimum, $maximum)
	{
		if (preg_match('/^[a-zA-Z0-9ñÑáÁéÉíÍóÓúÚ\s\.]{'.$minimum.','.$maximum.'}$/', $value)) {
			return true;
		} else {
			return false;
		}
	}
	public function validateUsername($value){
		if (strlen($value) > 7) {
			return true;
		} else {
			return false;
		}
	}
	
	public function validatePassword($value)
	{
		if (strlen($value) > 8) {
			return true;
		} else {
			return false;
		}
	}
	function IsDateTime($DateTime) {
			if (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$DateTime)) {
					return true;
			} else {
					return false;
			}
	}
	public function validateDate($value){
		if(preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$value)) {
			return true;
		} else {
			return false;
		}
	}
	public function validateToday($value){
			$today = date("Y-m-d");
			$userDate = $value;
			if ($today <= $userDate) {
				return true;
			}
			else {
				return false;
			}
	}
	public function validateCellphone($cellphone){
		if( strlen($cellphone) <= 8 ){
			return true;
		}
		else{
			return false;
		}
	}
	public function setCellphone ($cellphone) {
		$complete = str_split($cellphone,4);
		$completeCellphone = $complete[0].'-'.$complete[1];
		return $completeCellphone;
	}
}


?>