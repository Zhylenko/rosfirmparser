<?php
	class FileManipulator
	{
		public function create($filePath)
		{
			file_put_contents($filePath, '');
		}
		
		public function delete($filePath)
		{
			unlink($filePath);
		}
		
		public function copy($filePath, $copyPath)
		{
			copy($filePath, $copyPath);
		}
		
		public function rename($filePath, $newName)
		{
			preg_match_all("#^(.*)\/.+\..+$#i", $filePath, $matches);
			$path = $matches[1][0];
			rename($filePath, $path."/".$newName);
		}
		
		public function replace($filePath, $newPath)
		{
			rename($filePath, $newPath);
		}
		
		public function weigh($filePath)
		{
			return filesize($filePath);
		}
	}
?>