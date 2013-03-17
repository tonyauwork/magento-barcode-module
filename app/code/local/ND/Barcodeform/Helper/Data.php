<?php
class ND_Barcodeform_Helper_Data extends Mage_Core_Helper_Abstract
{
	protected static $code39 = array(
	'0' => 'bwbwwwbbbwbbbwbw','1' => 'bbbwbwwwbwbwbbbw',
	'2' => 'bwbbbwwwbwbwbbbw','3' => 'bbbwbbbwwwbwbwbw',
	'4' => 'bwbwwwbbbwbwbbbw','5' => 'bbbwbwwwbbbwbwbw',
	'6' => 'bwbbbwwwbbbwbwbw','7' => 'bwbwwwbwbbbwbbbw',
	'8' => 'bbbwbwwwbwbbbwbw','9' => 'bwbbbwwwbwbbbwbw',
	'A' => 'bbbwbwbwwwbwbbbw','B' => 'bwbbbwbwwwbwbbbw',
	'C' => 'bbbwbbbwbwwwbwbw','D' => 'bwbwbbbwwwbwbbbw',
	'E' => 'bbbwbwbbbwwwbwbw','F' => 'bwbbbwbbbwwwbwbw',
	'G' => 'bwbwbwwwbbbwbbbw','H' => 'bbbwbwbwwwbbbwbw',
	'I' => 'bwbbbwbwwwbbbwbw','J' => 'bwbwbbbwwwbbbwbw',
	'K' => 'bbbwbwbwbwwwbbbw','L' => 'bwbbbwbwbwwwbbbw',
	'M' => 'bbbwbbbwbwbwwwbw','N' => 'bwbwbbbwbwwwbbbw',
	'O' => 'bbbwbwbbbwbwwwbw','P' => 'bwbbbwbbbwbwwwbw',
	'Q' => 'bwbwbwbbbwwwbbbw','R' => 'bbbwbwbwbbbwwwbw',
	'S' => 'bwbbbwbwbbbwwwbw','T' => 'bwbwbbbwbbbwwwbw',
	'U' => 'bbbwwwbwbwbwbbbw','V' => 'bwwwbbbwbwbwbbbw',
	'W' => 'bbbwwwbbbwbwbwbw','X' => 'bwwwbwbbbwbwbbbw',
	'Y' => 'bbbwwwbwbbbwbwbw','Z' => 'bwwwbbbwbbbwbwbw',
	'-' => 'bwwwbwbwbbbwbbbw','.' => 'bbbwwwbwbwbbbwbw',
	' ' => 'bwwwbbbwbwbbbwbw','*' => 'bwwwbwbbbwbbbwbw',
	'$' => 'bwwwbwwwbwwwbwbw','/' => 'bwwwbwwwbwbwwwbw',
	'+' => 'bwwwbwbwwwbwwwbw','%' => 'bwbwwwbwwwbwwwbw');
    
	const DestDir = "barcode";
	
	private	$baseDir = null;
	private $imgfile = null;	
	private $imgurl = null;
		
	public function Code39($text, $height = 50, $widthScale = 1) {
		if (!file_exists($this->getimgfile($data)))
		{
			if (!preg_match('/^[A-Z0-9-. $+\/%]+$/i', $text)) {
				throw new Exception('Invalid text input.');
			}

			$text = '*' . strtoupper($text) . '*'; // *UPPERCASE TEXT*
			$length = strlen($text);

			$barcode = imageCreate($length * 16 * $widthScale, $height);

			$bg = imagecolorallocate($barcode, 255, 255, 0); //sets background to yellow
			imagecolortransparent($barcode, $bg); //makes that yellow transparent
			$black = imagecolorallocate($barcode, 0, 0, 0); //defines a color for black

			$chars = str_split($text);

			$colors = '';

			foreach ($chars as $char) {
				$colors .= self::$code39[$char];
			}

			foreach (str_split($colors) as $i => $color) {
				if ($color == 'b') {
					// imageLine($barcode, $i, 0, $i, $height-13, $black);
					imageFilledRectangle($barcode, $widthScale * $i, 0, $widthScale * ($i+1) -1 , $height-13, $black);
				}
			}

			//16px per bar-set, halved, minus 6px per char, halved (5*length)
			// $textcenter = $length * 5 * $widthScale;
			$textcenter = ($length * 8 * $widthScale) - ($length * 3);

			imageString($barcode, 2, $textcenter, $height-13, $text, $black);

			//header('Content-type: image/png');
			imagePNG($barcode, $this->imgfile);
			imageDestroy($barcode);
		}
		return $this->imgurl;
	}

	
	const API_CHART_URL = "http://chart.apis.google.com/chart";
	public function Qr($data, $size = 150) {
		if (!file_exists($this->getimgfile($data)))
		{
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, self::API_CHART_URL);
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, "chs={$size}x{$size}&cht=qr&chl=" . urlencode($data));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HEADER, false);
			curl_setopt($ch, CURLOPT_TIMEOUT, 30);
			$img = curl_exec($ch);
			curl_close($ch);

			if($img) {
				file_put_contents($this->imgfile, $img);
			}
		}
		return $this->imgurl;
	}
	
	private function getimgfile($data){
		if (!$this->baseDir) {
			$this->baseDir = Mage::getBaseDir('media'). DS. self::DestDir;
			$ioObject = new Varien_Io_File();        
			try {
				$ioObject->open(array('path'=>$this->baseDir));
			} catch (Exception $e) {
				$ioObject->mkdir($this->baseDir, 0777, true);
				$ioObject->open(array('path'=>$this->baseDir));
			}
		}
		
		$md5name = md5($data).'.png';
		$this->imgfile = $this->baseDir. DS . $md5name;
		$this->imgurl = Mage::getBaseUrl('media'). self::DestDir . "/". $md5name;
		return $this->imgfile;
	}	
}