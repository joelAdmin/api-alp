<?php
	namespace App\Lib;
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;
	use PHPMailer\PHPMailer\Exception;
	use Illuminate\Support\Facades\Auth;

    Class Functions 
    {
		public function genera_num_rango($start, $count, $digits) 
		{
			$result = array();
			for ($n = $start; $n < $start + $count; $n++) {
			   $result[] = str_pad($n, $digits, "0", STR_PAD_LEFT);
			}
			return $result;
		 }

		 public function num_factura($valor, $digits) 
		 {
			
			$result = str_pad($valor, $digits, "0", STR_PAD_LEFT);
			return $result;
		 }

		public function generateRandomString($length = 10) 
		{
			$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			$charactersLength = strlen($characters);
			$randomString = '';
			for ($i = 0; $i < $length; $i++) {
				$randomString .= $characters[rand(0, $charactersLength - 1)];
			}
			return $randomString;
		}
		public static function f_hour()
		{
			$hora= @getdate(time());
			$hora_reg=$hora["hours"].":".$hora["minutes"].":".$hora["seconds"];
				return $hora_reg;
			
		}
		Public static function renameImg($prefijo, $formato)
		{
			$codigo=$prefijo.''.rand();
			$nombreArchivo=$codigo.'.'.$formato; //para que todas la imagenes esten en el mismo formato
			return $nombreArchivo;	
		}

		Public static function renameFile($prefijo, $formato)
		{
			$codigo=$prefijo.''.rand();
			$nombreArchivo=$codigo.'.'.$formato; //para que todas la imagenes esten en el mismo formato
			return $nombreArchivo;	
		}

		public static function decimalDB($value)
		{
			$csv1 = str_replace('.','', $value);
			$csv1 = str_replace(',','.', $csv1);
			return (float) $csv1;
		}

		public static function integerDB($value)
		{
			$csv1 = str_replace('.','', $value);
			return (int) $csv1;
		}

		public static function moneda($value)
		{
			$result = number_format($value,2,',','.').' $';
			return $result;
		}

		public static function typeImage($image)
		{
			if(
				($image=='image/gif') || ($image=='	image/png') || ($image=='image/jpeg') || ($image=='image/png') || ($image=='application/x-shockwave-flash') || ($image=='image/psd')||
				($image=='image/bmp') || ($image=='image/tiff') || ($image=='image/tiff') || ($image=='application/octet-stream')|| ($image=='	image/jp2') ||
				($image=='image/iff') || ($image=='image/vnd.wap.wbmp') || ($image=='image/xbm') || ($image=='image/vnd.microsoft.icon')
			)
			{
				return true;
			}else{
				return false;
			}
		}

		public static function strTextoComillaDoble($texto)
		{
			$string = $texto;
			$array = explode('"', $string);
			$palabras = array();
			$result = '';
			for($i=1; $i<count($array); $i=$i+2){
				if($i!=(count($array)-1) || count($array)%2!==0) {
					$result .= $array[$i];
					$palabras[] = $array[$i];
				}
			}

			return $result;
		}

		
		public static function getBrowser()
		{
			$user_agent = $_SERVER['HTTP_USER_AGENT'];
			if(strpos($user_agent, 'MSIE') !== FALSE)
				return 'Internet explorer';
			elseif(strpos($user_agent, 'Edge') !== FALSE) //Microsoft Edge
				return 'Microsoft Edge';
			elseif(strpos($user_agent, 'Trident') !== FALSE) //IE 11
				return 'Internet explorer';
			elseif(strpos($user_agent, 'Opera Mini') !== FALSE)
				return "Opera Mini";
			elseif(strpos($user_agent, 'Opera') || strpos($user_agent, 'OPR') !== FALSE)
				return "Opera";
			elseif(strpos($user_agent, 'Firefox') !== FALSE)
				return 'Mozilla Firefox';
			elseif(strpos($user_agent, 'Chrome') !== FALSE)
				return 'Google Chrome';
			elseif(strpos($user_agent, 'Safari') !== FALSE)
				return "Safari";
			else
				return 'No hemos podido detectar su navegador';
		 
		}

		public static function getBrowserCss()
		{
			$user_agent = $_SERVER['HTTP_USER_AGENT'];
			if(strpos($user_agent, 'MSIE') !== FALSE)
				echo "<link href=\"{{ asset('template/01/css/app.css') }}\" rel='stylesheet'>";
			elseif(strpos($user_agent, 'Edge') !== FALSE) //Microsoft Edge
				echo "<link href=\"{{ asset('template/01/css/app.css') }}\" rel='stylesheet'>";
			elseif(strpos($user_agent, 'Trident') !== FALSE) //IE 11
				echo "<link href=\"{{ asset('template/01/css/app.css') }}\" rel='stylesheet'>";
			elseif(strpos($user_agent, 'Opera Mini') !== FALSE)
				echo "<link href=\"{{ asset('template/01/css/app.css') }}\" rel='stylesheet'>";
			elseif(strpos($user_agent, 'Opera') || strpos($user_agent, 'OPR') !== FALSE)
				echo "<link href=\"{{ asset('template/01/css/app.css') }}\" rel='stylesheet'>";
			elseif(strpos($user_agent, 'Firefox') !== FALSE)
				echo "<link href=\"{{ asset('template/01/css/appFirefox.css') }}\" rel='stylesheet'>";
			elseif(strpos($user_agent, 'Chrome') !== FALSE)
				echo "<link href=\"{{ asset('template/01/css/app.css') }}\" rel='stylesheet'>";
			elseif(strpos($user_agent, 'Safari') !== FALSE)
				echo "<link href=\"{{ asset('template/01/css/app.css') }}\" rel='stylesheet'>";
			else
				echo "<link href=\"{{ asset('template/01/css/app.css') }}\" rel='stylesheet'>";
		 
		}
		

		public static function calculaHra()
		{
			$arreglo       = array();
			$datetimer_now = date('Y-m-j H:i:s');
			$datetimer     = strtotime('+10 minute', strtotime($datetimer_now));
			$newdate       = date('H:i:s', $datetimer);
			$arreglo       = explode(':', $newdate);
			return 'hora actual:'.$datetimer_now.'<br> / h-'.$arreglo[0].'-m-'.$arreglo[1].'s-'.$arreglo[2];
		}

		public static function datetimeDiff()
		{
			/** created timer 10 minute en db 02:57:27*/
			$datetime1 = date_create('15:15:28');
			/** stop timer for update status 03:04:43 */
			$datetime2 = date_create('15:16:01');

			/** start timer for update status 03:06:54*/
			$datetime3 = date_create('15:16:57');
			$hrs_start = '15:16:57';
			/** diff datetime1 && datetime2 */
			$interval = date_diff($datetime1, $datetime2);	
			$result = $interval->format("%H:%I:%S");
			$resul          = explode(':', $result);
			//dd($result);

			$datet = strtotime('+10 minute', strtotime($hrs_start));
            $hrs_new = date('H:i:s', $datet);
			//00:01:35
			//$datetimer = strtotime('-03 minute 20 seconds 00 hours',strtotime($datetimer_now));	
			$datetimer     = strtotime('-00 minute',strtotime('15:26:57'));
			$newdate       = date('H:i:s', $datetimer);
			$datetimer     = strtotime('-33 seconds', strtotime($newdate));	
			$newdate       = date('H:i:s', $datetimer);
			//dd($newdate);
			$datetimer     = strtotime('-'.$resul[1].' minute '.$resul[2].' seconds '.$resul[0].' hours', strtotime($hrs_new));	
					
			$newdate       = date('H:i:s', $datetimer);

			$mostrar = 'start timer:'.$hrs_start.'/hrs +10 min:'.$hrs_new.'/descuento diff:'.$result.'/resul:'.$newdate;
			//dd($mostrar);
			return true;	
			//return 'start timer:'.$hrs_start.'/descuento diff:'.$result.'/hrs +10 min:'.$hrs_new.'/resul:'.$newdate;
		}

	

		public static function explodeStr($filtro, $str )
		{
			$porciones = explode($filtro, $str);
			return $porciones;
		}

		public static function getImg($url)
		{
			return storage_path($url);
		}
		
		public static function getMediaFile($filename) {
			$rangeHeader = request()->header('Range');
			$fileContents = \Storage::disk(\App\Helpers\CoachingCallsHelper::DISK)->get($filename);
			$fullFilePath = \Storage::disk(\App\Helpers\CoachingCallsHelper::DISK)->path($filename); //https://stackoverflow.com/a/49532280/470749
			$headers = ['Content-Type' => Storage::disk(\App\Helpers\CoachingCallsHelper::DISK)->mimeType($fullFilePath)];
			if ($rangeHeader) {
				return self::getResponseStream(\App\Helpers\CoachingCallsHelper::DISK, $fullFilePath, $fileContents, $rangeHeader, $headers);
			} else {
				$httpStatusCode = 200;
				return response($fileContents, $httpStatusCode, $headers);
			}
		}

		public static function getMp3($filename) {
			$fileContents = \Storage::disk(\App\Helpers\CoachingCallsHelper::DISK)->get($filename);
			$fileSize = \Storage::disk(\App\Helpers\CoachingCallsHelper::DISK)->size($filename);
			$shortlen = $fileSize - 1;
			$headers = [
				'Accept-Ranges' => 'bytes',
				'Content-Range' => 'bytes 0-' . $shortlen . '/' . $fileSize,
				'Content-Type' => "audio/mpeg"
			];
			Log::debug('$headers=' . json_encode($headers));
			$response = response($fileContents, 200, $headers);
			return $response;
		}

		public static function getfile($filename) {
			
			$size = \Storage::disk('app')->size('files/'.$filename);			
			$file = \Storage::disk('app')->get('files/'.$filename);
			$stream = fopen($storage_home_dir.'files/'.$filename, "r");
			
			$type = 'audio/aac';
			$start = 0;
			$length = $size;
			$status = 200;
			
			$headers = ['Content-Type' => $type, 'Content-Length' => $size, 'Accept-Ranges' => 'bytes'];
			
			if (false !== $range = Request::server('HTTP_RANGE', false)) {
				list($param, $range) = explode('=', $range);
				if (strtolower(trim($param)) !== 'bytes') {
				header('HTTP/1.1 400 Invalid Request');
				exit;
				}
				list($from, $to) = explode('-', $range);
				if ($from === '') {
				$end = $size - 1;
				$start = $end - intval($from);
				} elseif ($to === '') {
				$start = intval($from);
				$end = $size - 1;
				} else {
				$start = intval($from);
				$end = intval($to);
				}
				$length = $end - $start + 1;
				$status = 206;
				$headers['Content-Range'] = sprintf('bytes %d-%d/%d', $start, $end, $size);
			}
			
			return Response::stream(function() use ($stream, $start, $length) {
				fseek($stream, $start, SEEK_SET);
				echo fread($stream, $length);
				fclose($stream);
				}, $status, $headers);
		}

		

		public static function notEmail()
		{
			$codigo = rand(1000, 99999);
        	return 'not'.$codigo.'@'.@$_SERVER["SERVER_NAME"];
		}

    }