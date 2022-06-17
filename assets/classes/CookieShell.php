<?php
	class CookieShell
	{
		public function set($name, $value, $time)
		{
			setcookie($name, $value, time() + $time, "/");
			$_COOKIE[$name] = $value;
		}
		
		public function get($name)
		{
			return $_COOKIE[$name];
		}
		
		public function del($name)
		{
			unset($_COOKIE[$name]);
			$_COOKIE[$name] = null;
		}
		
		public function exists($name)
		{
			return isset($_COOKIE[$name]);
		}
	}
?>