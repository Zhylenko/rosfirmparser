<?php
	class Validator
	{
		public function isEmail($str)
		{
			preg_match_all("#^[\w\-\_\.а-яА-яЁё]{4,}\@[\w\-\_\.а-яА-яЁё]{4,15}\.[\w\-\_\.а-яА-яЁё]{2,5}$#ui", $str, $emails);
			$email = $emails[0][0];
			if($email){
				return true;
			}else{
				return false;
			}
		}
		
		public function isDomain($str)
		{
			preg_match_all("#^(https?://)?([\w\-а-яА-яЁё]{2,}\.)+([\w\-а-яА-яЁё]{2,15}\.?){1,2}(\/[\w\-\_а-яА-яЁё]+)*\/?$#ui", $str, $domains);
			$domain = $domains[0][0];
			if($domain){
				return true;
			}else{
				return false;
			}
		}
		
		public function inRange($num, $from, $to)
		{
			return (($num >= $from) && ($num <= $to));
		}
		
		public function inLength($str, $from, $to)
		{
			return ((strlen($str) >= $from) && (strlen($str) <= $to));
		}
	}
?>