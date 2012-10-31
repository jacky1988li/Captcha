<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');



/**

 * 

 */

class Captcha {

	

	public $font_path = './system/fonts/texb.ttf';

	public $img = NULL;

	// public $img_path = './captcha/';	

	public $img_url = 'http://www.ci.dev/captcha/';

	public $img_width = 100;

	public $img_height = 28;

	public $expiration = 7200;

	public $length = 4;

	public $fontsize = 16;



	public $bgColorArray = array(

		'R'=>250,

		'G'=>250,

		'B'=>250

	);



	public $textColorArray = array(

		'R'=>120,

		'G'=>100,

		'B'=>250

	);



	public $lineColorArray = array(

		'R'=>150,

		'G'=>150,

		'B'=>150

	);



	public $pixelColorArray = array(

		'R'=>200,

		'G'=>200,

		'B'=>200

	);



	public $borderColorArray = array(

		'R'=>50,

		'G'=>60,

		'B'=>70

	);



	public $word = '';

	public $bgColor = '';

	public $borderColor = '';

	public $textColor = '';

	public $lineColor = '';

	public $pixelColor = '';

	public $now = NULl;

	public $img_name = '';

	public $lowerWord = '';



	public function __construct($params = array())

	{		

		if (count($params) > 0)

		{

			$this->initialize($params);

		}

	}





	/**

	 * 初始化

	 *

	 * @access	public

	 * @param	array	initialization parameters

	 * @return	void

	 */

	public function initialize($params = array())

	{

		if (count($params) > 0)

		{

			foreach ($params as $key => $val)

			{

				if (isset($this->$key))

				{

					$this->$key = $val;

				}

			}

		}

	}



	/**

	 * 创建4个随机码

	 * 

	 * @access private 

	 * @param null $ 

	 * @return void 

	 */

	public function createWord()

	{

		for($i=0;$i<$this->length;$i++){

			$this->word.= dechex(mt_rand(1,15));

		}

	}



	/**

	 * 创建画布

	 * @return [type] [description]

	 */

	public function createImg()

	{

		$this->img = imagecreatetruecolor($this->img_width, $this->img_height);

	}



	/**

	 * 设置背景颜色

	 */

	public function setBgColor()

	{

		$this->bgColor = imagecolorallocate($this->img, $this->bgColorArray['R'], $this->bgColorArray['G'], $this->bgColorArray['B']); 

	}

	

	/**

	 * 创建背景

	 * @return [type] [description]

	 */

	public function createBg()

	{

		ImageFilledRectangle($this->img, 0, 0, $this->img_width, $this->img_height, $this->bgColor);

	}



	/**

	 * 设置边框颜色

	 */

	public function setBorderColor()

	{

		$this->borderColor = imagecolorallocate($this->img, $this->borderColorArray['R'], $this->borderColorArray['G'], $this->borderColorArray['B']); 

	}



	/**

	 * 创建边框

	 * @return [type] [description]

	 */

	public function createBorder()

	{

		imagerectangle($this->img, 0, 0, $this->img_width-1, $this->img_height-1, $this->borderColor);

	}





	/**

	 * 设置文字颜色

	 */

	public function setTextColor()

	{

		$this->textColor = imagecolorallocate ($this->img, $this->textColorArray['R'], $this->textColorArray['G'], $this->textColorArray['B']);

	}



	/**

	 * 用 TrueType 字体向图像写入文本

	 * @return [type] [description]

	 */

	public function drawWord()

	{

		for ($i = 0;$i < $this->length;$i++)

		{

			imagettftext($this->img, $this->fontsize, 0, $this->img_width/10 + $i*20, $this->img_height/1.4, $this->textColor, $this->font_path, $this->word[$i]);

		}

	}



	/**

	 * 设置线条颜色

	 * @return [type] [description]

	 */

	public function setLineColor()

	{

		$this->lineColor = imagecolorallocate ($this->img, $this->lineColorArray['R'], $this->lineColorArray['G'], $this->lineColorArray['B']);

	}



	/**

	 * 随机线条

	 * @return [type] [description]

	 */

	public function createLine()

	{

		for ($i = 0;$i < 6;$i++)

		{

			imageline($this->img, mt_rand(0, $this->img_width), mt_rand(0, $this->img_height), mt_rand(0, $this->img_width), mt_rand(0, $this->img_height), $this->lineColor);

		}

	}



	/**

	 * 设置像素点颜色

	 * @return [type] [description]

	 */

	public function setPixelColor()

	{

		$this->pixelColor = imagecolorallocate ($this->img, $this->pixelColorArray['R'], $this->pixelColorArray['G'], $this->pixelColorArray['B']);

	}



	/**

	 * 画多个随机像素点

	 * @return [type] [description]

	 */

	public function createPixel()

	{

		for ($i = 0;$i < 500;$i++)

		{

			imagesetpixel($this->img, mt_rand(0, $this->img_width), mt_rand(0, $this->img_height), $this->pixelColor);

		}		

	}

	/**

	 * 设置文件名

	 * @return [type] [description]

	 */

	public function setFilename()

	{

		list($usec, $sec) = explode(" ", microtime());

		$this->now = ((float)$usec + (float)$sec);

		$this->img_name = $this->now.'.png';

	}



	/**

	 * 以 PNG 格式将图像输出到浏览器或文件

	 */

	public function createImgage()

	{
		// imagepng($this->img, $this->img_path.$this->img_name);
		imagepng($this->img);
		$this->image = "<img src=\"$this->img_url\" width=\"$this->img_width\" height=\"$this->img_height\"  alt=\"点击换一张\" class=\"code-pic\" title=\"点击换一张\" />";

		imagedestroy($this->img);

		// return array('word' => $this->lowerWord, 'time' => $this->now, 'image' => $this->image, "src"=>$this->img_url.$this->img_name);

		return array('word' => $this->lowerWord, "src"=>$this->img_url);

	}



	/**

	 * 获取验证码

	 * 

	 * @access private 

	 * @param null $ 

	 * @return void 

	 */

	public function getWord()

	{

		return $this->lowerWord = strtolower($this->word);

	}

	



	public function getImage()

	{

		$this->createWord();

		$this->createImg();

		$this->setBgColor();

		$this->createBg();

		// $this->setBorderColor();

		// $this->createBorder();

		$this->setTextColor();

		$this->drawWord();

		// $this->setLineColor();

		// $this->createLine();

		$this->setPixelColor();

		$this->createPixel();

		$this->setFilename();

		$this->getWord();

		$outPut = $this->createImgage();

		return $outPut;

	}

}
