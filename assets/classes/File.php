<?php 
	interface iFile
	{
		public function __construct($filePath);
		
		public function getPath(); // путь к файлу
		public function getDir();  // папка файла
		public function getName(); // имя файла
		public function getExt();  // расширение файла
		public function getSize(); // размер файла
		
		public function getText();          // получает текст файла
		public function setText($text);     // устанавливает текст файла
		public function appendText($text);  // добавляет текст в конец файла
		
		public function copy($copyPath);    // копирует файл
		public function delete();           // удаляет файл
		public function rename($newName);   // переименовывает файл
		public function replace($newPath);  // перемещает файл
	}

	class File implements iFile{
		private $filePath;

		public function __construct($filePath = '')
		{
			$this->filePath = $filePath;
		}

		public function getPath()
		{
			return $this->filePath;
		}

		public function getDir()
		{
			preg_match_all("#^(.*)\/.+\..+$#i", $this->getPath(), $matches);
			$matches = $matches[1][0];
			return $matches;
		}

		public function getName()
		{
			preg_match_all("#^.*\/(.+)\..+$#i", $this->getPath(), $matches);
			$matches = $matches[1][0];
			return $matches;
		}

		public function getExt()
		{
			preg_match_all("#^.*\/.+\.(.+)$#i", $this->getPath(), $matches);
			$matches = $matches[1][0];
			return $matches;
		}

		public function getSize()
		{
			return filesize($this->getPath());
		}

		public function getText()
		{
			return htmlspecialchars(file_get_contents($this->getPath()));
		}

		public function setText($text)
		{
			file_put_contents($this->getPath(), $text);
			return $this;
		}

		public function appendText($text)
		{
			$content = htmlspecialchars_decode($this->getText()).$text;
			$this->setText($content);
		}

		public function copy($copyPath)
		{
			copy($this->getPath(), $copyPath);
			return $this;
		}

		public function delete()
		{
			unlink($this->getPath());
			$this->filePath = null;
		}

		public function rename($newName)
		{
			rename($this->getPath(), $newName);
			return $this;
		}

		public function replace($newPath)
		{
			rename($this->getPath(), $newPath);
			$this->filePath = $newPath;
			return $this;
		}
	}
?>