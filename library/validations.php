<?php
class Validation
{
/*
Usage:
alphanum, alpha, alphanospace, num, dec, email, url

$val = new Validation();
$val->addRule($value,'num','Field 1', true, false, false );
*/
	var $error = array();
	//field name, type, req, min, max, error msg//
	function addRule($field, $type, $label, $req=false, $min=false, $max=false,$size=false)
	{
		if($req==true and trim($field) =='')
		{
			$this->error[] = $label.' Is Required' ;
			return false;
		}

		if($min)
		{
			if(strlen($field)<$min)
			{
				$this->error[] = MINIMUM." $min ".CHAR_REQUIRE_IN." $label";
				return false;
			}
		}

		if($max)
		{
			if(strlen($field)>$max)
			{
				$this->error[] = MAXIMUM." $max ".CHAR_ALLOWED_IN." $label";
				return false;
			}
		}


		if($type=='alphanum')
		{
			$result = ereg ("^[A-Za-z0-9\ ]+$", $field);
			if (!$result)
			{
				$this->error[] = PLEASE_ENTER_VALID_CHAR." $label";
				return false;
			}
		}
		elseif($type=='alpha')
		{
			$result = ereg ("^[A-Za-z\'\ ]+$", $field);
			if (!$result)
			{
				$this->error[] = PLEASE_ENTER_ALPHABETS." $label";
				return false;
			}
		}
                elseif($type=='code')
		{
			$result = ereg ("^[A-Z_]+$", $field);
			if (!$result)
			{
				$this->error[] = PLEASE_ENTER_VALID." $label";
				return false;
			}
		}
		elseif($type=='drop')
		{
			if($field=="")//if($field=="0")
			{
				$this->error[] = PLEASE_SELECT." $label.";
				return false;
			}
			elseif($field=="")
			{
				$this->error[] = PLEASE_SELECT." $label.";
				return false;
			}
		}
		elseif($type=='alphanospace')
		{
			$result = ereg ("^[A-Za-z\]+$", $field);
			if (!$result)
			{
				$this->error[] = PLEASE_ENTER_ALPHABETS." $label";
				return false;
			}
		}
		elseif($type=='smallalphanospace')
		{
			$result = ereg ("^[a-z\]+$", $field);
			if (!$result)
			{
				$this->error[] = ENTER_SMALL_LETTER_WITOUT_SPACE." $label";
				return false;
			}
		}
		elseif($type=='num')
		{
			$result = ereg ("^[0-9\ ]+$", $field);
			if (!$result)
			{
				$this->error[] = PLEASE_ENTER_NUM_N." $label";
				return false;
			}
		}

		elseif($type=='dec')
		{
			$result = ereg ("^[0-9\.]+$", $field);
			if (!$result)
			{
				$this->error[] = PLEASE_ENTER_NUM_N." $label";
				return false;
			}
		}
		elseif($type=='price')
		{
			if($field == 0)
			{
				$this->error[] = ENTER_VALID_PRICE;
				return false;
			}
			else
			{
				$result = ereg ("^[0-9\.]+$", $field);
				if (!$result)
				{
					$this->error[] = PLEASE_ENTER_NUM_N." $label";
					return false;
				}
			}
		}
		elseif($type=='email')
		{
			$result = ereg ("^[^@ ]+@[^@ ]+\.[^@ \.]+$", $field);
			if (!$result)
			{
				$this->error[] = "Please Enter Valid "." $label";
				return false;
			}
		}
		elseif($type=='email2')
		{
			//$result = ereg ("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $field);
			$result = ereg ("^[^@ ]+@[^@ ]+\.[^@ \.]+$", $field);
			if (!$result)
			{
				$this->error[] = PLEASE_ENTER_VALID_EMAIL;
				return false;
			}
		}
		elseif($type=='email3')
		{

			$result = ereg ("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $field);
			if (!$result)
			{
				$this->error[] = PLEASE_ENTER_VALID." $label ".IN_EMAIL_ADDRESS;
				return false;
			}
		}
		elseif($type=='url')
		{
			//|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i

			$result = preg_match('/((?:https?\:\/\/|www\.)(?:[-a-z0-9]+\.)*[-a-z0-9]+.*)/i', $field);
			if (!$result)
			{
				$this->error[] = PLEASE_ENTER_VALID_URL." $label";
				return false;
			}
		}
		elseif($type=='contact')
		{
			////ereg ("^[0-9]+[-]*[0-9]+$", $field)
//			$result = preg_match('/^(NA|[0-9+-]+)$/',$field);
//			if (!$result)
//			{
//				$this->error[] = "Please Enter Only Digits & Hyphen in $label";
//				return false;
//			}

			 //Pattrerns which we follow
		   // +91-9893111128
//			(+91)9893111128
//			1-(123)-123-1234
//			+1(123)-123-1234
//			123456789
//			(910)456-7890
			//$result  = ereg("^\+?([0-9]( |-)?)?(\(?[0-9]{3}\)?|[0-9]{3})( |-)?([0-9]{3}( |-)?[0-9]{4}|[a-zA-Z0-9]{8})$", $field );
//			$result1 = ereg("^([\+][0-9]{2}\-)[0-9]{10}$", $field );
//			$result2 = ereg("^([\(][0][0-9]{2}[\)])[\-][0-9]{10}$", $field );
//			$result3 = ereg("^([\(][\+][0-9]{2}[\)])[0-9]{10}$", $field );

			if(!preg_match(REGX_PHONE, $field) &&  $field!='' )
			{
				$this->error[] = PLEASE_ENTER_VALID." $label";
				return false;
			}

			//if (!$result && !$result1 && !$result2 && !$result3)
//			{
//				$this->error[] = "Please enter valid $label.";
//				return false;
//			}
		 }
		elseif($type=='image')
		{

			$ext = end(explode('.', strtolower($field)));
			//$pic = basename($field);
//			$ext = strtolower(substr($pic, strrpos($pic, '.') + 1));
			if($ext != '' && !in_array($ext,array('jpeg','jpg','png','gif')))
			{
				$this->error[] = IMAGE_VALIDATION_VAL_FILE." $label";
				return false;
			}
		}
		elseif($type=='imagesize')
		{
			if($field > $size)
			{
				$kbsize = $size/1024;
				$this->error[] = "$label ".SIZE_SHOULD_BE_LESS." $kbsize ".KB_IN_SIZE;
				return false;
			}
		}
	}

	function oldPassword($field1,$field2)
	{
		if($field1!=$field2)
		{
			$this->error[] = CURRENT_PWD_NOT_MATCH;
			return false;
		}
	}
        function Alreadypwd($field,$msg)
	{

		if (!preg_match_all('$\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])(?=\S*[\W])\S*$', $field))
		{
		  $this->error[] = $msg;
		  return FALSE;
		}
		else
		{
		return TRUE;
		}

	}
	function confirmPassword($field1,$field2)
	{
		if($field1!=$field2)
		{
			$this->error[] = PASSWORD_NOT_MATCH;
			return false;
		}
	}

	function confirmValue($field1,$field2,$label)
	{
		if($field1!=$field2)
		{
			$this->error[] = "$label ".DOES_NOT_MATCH."";
			return false;
		}
	}

	function matchValue($field1,$field2,$label)
	{
		if($field1==$field2)
		{
			$this->error[] = "$label ".MUST_BE_DIFFERENT."";
			return false;
		}
	}
	function validate()
	{
		if(!count($this->error))
		{
			/*$stat = '';
			foreach($this->error as $k => $val)
			{
				$stat.=$val.'<br />';
			}*/
			return true;
		}
		else
		{
			return false;
		}
	}

	function errors()
	{

		return $this->error[0];

	}

}
?>
