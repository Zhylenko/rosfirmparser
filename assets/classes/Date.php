<?php 
	class Date
	{
		private $date;

		public function __construct($date = null)
		{
			if($date != null){
				$this->date = strtotime($date);
			}else{
				$this->date = time();
			}
		}
		
		public function getDay()
		{
			return date("d", $this->date);
		}
		
		public function getMonth($lang = null)
		{
			$month = array('en' => ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'], 'ru' => ['Январь', 'Февраль', 'Март', 'Апрель ', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь ']);

			if(array_key_exists($lang, $month)){
				return $month[$lang][(int)date("m", $this->date) - 1];
			}else{
				return date("m", $this->date);
			}
			
		}
		
		public function getYear()
		{
			return date("Y", $this->date);
		}
		
		public function getWeekDay($lang = null)
		{
			$weekday = array('en' => ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Satturday', 'Sunday'], 'ru' => ['Понедельник', 'Вторник', 'Среда', 'Четверг', 'Пятница', 'Суббота', 'Восскресенье']);

			if(array_key_exists($lang, $weekday)){
				return $weekday[$lang][(int)date("N", $this->date) - 1];
			}else{
				return date("N", $this->date);
			}
		}
		
		public function addDay($value)
		{
			// добавляет значение $value к дню
			$this->date += 3600 * 24 * $value;
			return $this;
		}
		
		public function subDay($value)
		{
			// отнимает значение $value от дня
			$this->date -= 3600 * 24 * $value;
			return $this;
		}
		
		public function addMonth($value)
		{
			// добавляет значение $value к месяцу
			$this->date += 3600 * 24 * 30 * $value;
			return $this;
		}
		
		public function subMonth($value)
		{
			// отнимает значение $value от месяца
			$this->date -= 3600 * 24 * 30 * $value;
			return $this;
		}
		
		public function addYear($value)
		{
			// добавляет значение $value к году
			$this->date += 3600 * 24 * 365 * $value;
			return $this;
		}
		
		public function subYear($value)
		{
			// отнимает значение $value от года
			$this->date -= 3600 * 24 * 365 * $value;
			return $this;
		}
		
		public function format($format = "Y-m-d")
		{
			// выведет дату в указанном формате
			// формат пусть будет такой же, как в функции date
			return date($format, $this->date);
		}
		
		public function __toString()
		{
			// выведет дату в формате 'год-месяц-день'
			return date("Y-m-d", $this->date);
		}
	}

	class Interval
	{
		private $date1, $date2;

		public function __construct(Date $date1, Date $date2)
		{
			$this->date1 = strtotime($date1);
			$this->date2 = strtotime($date2);
		}
		
		public function toDays()
		{
			// вернет разницу в днях
			return floor(abs($this->date1 - $this->date2) / (3600 * 24));
		}
		
		public function toMonths()
		{
			// вернет разницу в месяцах
			return floor(abs($this->date1 - $this->date2) / (3600 * 24 * 30));	
		}
		
		public function toYears()
		{
			// вернет разницу в годах
			return floor(abs($this->date1 - $this->date2) / (3600 * 24 * 365));
		}
		
		public function __toString()
		{
			// выведет результат в виде массива
			// ['years' => '', 'months' => '', 'days' => '']
			return array('years' => $this->toYears(), 'months' => $this->toMonths(), 'days' => $this->toDays());
		}
	}
?>