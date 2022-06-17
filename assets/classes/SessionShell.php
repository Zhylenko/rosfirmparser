<?php
	class SessionShell
	{
		// Удобно стартуем сессию в конструкторе класса:
		public function __construct($name, $value)
		{
			if (!isset($_SESSION)) {
				session_start();
			}
			$_SESSION[$name] = $value;
		}
		
		public function set($name, $value)
		{
			$_SESSION[$name] = $value;
			return $this;
		}
		
		public function get($name)
		{
			return $_SESSION[$name];
		}
		
		public function del($name)
		{
			unset($_SESSION[$name]);
		}
		
		public function exists($name)
		{
			return isset($_SESSION[$name]);
		}
		
		public function destroy($name)
		{
			session_destroy();
		}
	}
?>