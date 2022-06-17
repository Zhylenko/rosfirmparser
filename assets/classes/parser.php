<?php 
	namespace assets\classes;

	class Parser{
		private $url, $curl;
		
		public function __construct($url)
		{
			$this->setURL($url);
			$this->setCURL($url);
		}

		public function setURL($url)
		{
			$this->url = $url;
			$this->setCURL($url);
		}

		public function getPage()
		{
			$curl = $this->curl;

			if(!empty($curl)){

				$result = curl_exec($curl);

				if($result === false){
					return "CURL error : ".curl_error($curl);
				}else{
					return $result;
					curl_close($curl);
				}
			}else{
				return "CURL error";
			}
		}

		public function getErrors()
		{
			$curl = $this->curl;
			return curl_error($curl);
		}

		public function setFields($fields)
		{
			$curl = $this->curl;

			curl_setopt($curl, CURLOPT_POSTFIELDS, $fields);

			$this->curl = $curl;
		}

		public function setCookies($cookies = '')
		{
			$curl = $this->curl;
			$cookieFileFullPath = "/text.txt";

			curl_setopt($curl, CURLOPT_HEADER, 1);

			curl_setopt($curl, CURLOPT_COOKIEJAR, $_SERVER['DOCUMENT_ROOT'].$cookieFileFullPath);
			curl_setopt($curl, CURLOPT_COOKIEFILE, $_SERVER['DOCUMENT_ROOT'].$cookieFileFullPath);
			curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1)');
			curl_setopt($curl, CURLOPT_COOKIE, $cookies);
			
			$this->curl = $curl;
		}

		private function setCURL()
		{
			$curl = $this->curl;
			$curl = curl_init();

			curl_setopt($curl, CURLOPT_URL, $this->url);
			curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1)');
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);

			$this->curl = $curl;
		}
	}
?>