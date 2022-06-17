<?php
	class DatabaseShell
	{
		private $link;
		
		public function __construct($host, $user, $password, $database)
		{
			$this->link = mysqli_connect($host, $user, $password, $database);
			mysqli_query($this->link, "SET NAMES 'utf8'"); // устанавливаем кодировку
		}
		
		public function save($table, $data)
		{
			// сохраняет запись в базу
			$columns = [];
			$values = [];

			foreach ($data as $column => $value) {
				$columns[] = "`$column`";
				$values[] = "'$value'";
			}

			$columns = implode(", ", $columns);
			$values = implode(", ", $values);

			$query = "INSERT INTO `{$table}`({$columns}) VALUES ({$values})";

			$this->link->query($query);
		}
		
		public function del($table, $id)
		{
			// удаляет запись по ее id
			$query = "DELETE FROM `{$table}` WHERE `{$table}`.`id` = '{$id}'";

			$this->link->query($query);
		}
		
		public function delAll($table, $ids)
		{
			// удаляет записи по их id
			foreach ($ids as $id) {
				$query = "DELETE FROM `{$table}` WHERE `{$table}`.`id` = '{$id}'";

				$this->link->query($query);
			}
		}
		
		public function get($table, $id)
		{
			// получает одну запись по ее id
			$query = "SELECT * FROM `{$table}` WHERE `{$table}`.`id` = '{$id}'";

			$row = $this->link->query($query);
			return mysqli_fetch_all($row, MYSQLI_ASSOC);
		}
		
		public function getAll($table, $ids)
		{
			$rows = [];
			// получает массив записей по их id
			foreach ($ids as $id) {
				$query = "SELECT * FROM `{$table}` WHERE `{$table}`.`id` = '{$id}'";

				$row = $this->link->query($query);
				$rows[] = mysqli_fetch_all($row, MYSQLI_ASSOC);
			}

			return $rows;
		}
		
		public function selectAll($table, $condition)
		{
			// получает массив записей по условию
			$query = "SELECT * FROM `{$table}` WHERE {$condition}";

			$row = $this->link->query($query);

			return mysqli_fetch_all($row, MYSQLI_ASSOC);
		}
	}
?>