<?php

class Eve_Image {

	public  static function resample($source, $dest, $width, $height = false, $force = false) {
		// Get new dimensions
		$type = explode('.', $source);
		$type = array_pop($type);

		list($width_orig, $height_orig) = getimagesize($source);

		if ($width_orig < $width && $force == false) {
			return false;
		}

		$scaleX = $width / $width_orig;

		$width = round($width_orig * $scaleX);

		if ($height) {
			$scaleY = $height / $height_orig;

			$height = round($height_orig * $scaleY);
		} else {
			$height = round($height_orig * $scaleX);
		}


		// Resample
		$image_p = imagecreatetruecolor($width, $height);

		$image = self::_openImage($source);

		imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);

		switch ($type) {
			case 'gif':
				imagegif($image_p, $dest, 90);
				break;
			case 'jpg':
				imagejpeg($image_p, $dest, 90);
				break;
			case 'jpeg':
				imagejpeg($image_p, $dest, 90);
				break;
			case 'jpe':
				imagejpeg($image_p, $dest, 90);
				break;
			case 'png':
				imagealphablending( $image_p, false );
				imagesavealpha( $image_p, true);
				imagepng($image_p, $dest, 90);
				break;
		}
	}

	/**
	 *
	 * @param string $img
	 * @param int $w
	 * @param int $h
	 * @param string $newfilename
	 * @return string
	 */
	public static function resize($img, $w, $h, $newfilename, $keepProportional = false) {
        
		//Check if GD extension is loaded
		if (!extension_loaded('gd') && !extension_loaded('gd2')) {
			trigger_error("GD is not loaded", E_USER_WARNING);
			return false;
		}

		//Get Image size info
		$imgInfo = getimagesize($img);
		switch ($imgInfo[2]) {
			case 1: $im = imagecreatefromgif($img);
				break;
			case 2: $im = imagecreatefromjpeg($img);
				break;
			case 3: $im = imagecreatefrompng($img);
				break;
			default:  trigger_error('Unsupported filetype!', E_USER_WARNING);
				break;
		}
		
		//If image dimension is smaller, do not resize
		if ($imgInfo[0] <= $w && $imgInfo[1] <= $h) {
			$nHeight = $imgInfo[1];
			$nWidth = $imgInfo[0];
		}else {
			//yeah, resize it, but keep it proportional
			if($keepProportional){
				$scaleX = $w/$imgInfo[0];

				$nWidth = round($imgInfo[0] * $scaleX);
				$nHeight = round($imgInfo[1] * $scaleX);

				/**
				if ($w/$imgInfo[0] > $h/$imgInfo[1]) {
					$nWidth = $w;
					$nHeight = $imgInfo[1]*($w/$imgInfo[0]);
				}else {
					$nWidth = $imgInfo[0]*($h/$imgInfo[1]);
					$nHeight = $h;
				}
				 */
				
			} else {
				$nWidth = $w;
				$nHeight = $h;
			}
		}
		$nWidth = round($nWidth);
		$nHeight = round($nHeight);

		$newImg = imagecreatetruecolor($nWidth, $nHeight);

		/* Check if this image is PNG or GIF, then set if Transparent*/
		if(($imgInfo[2] == 1) OR ($imgInfo[2]==3)) {
			imagealphablending($newImg, false);
			imagesavealpha($newImg,true);
			$transparent = imagecolorallocatealpha($newImg, 255, 255, 255, 127);
			imagefilledrectangle($newImg, 0, 0, $nWidth, $nHeight, $transparent);
		}
		imagecopyresampled($newImg, $im, 0, 0, 0, 0, $nWidth, $nHeight, $imgInfo[0], $imgInfo[1]);

		//Generate the file, and rename it to $newfilename
		switch ($imgInfo[2]) {
			case 1: imagegif($newImg,$newfilename);
				break;
			case 2: imagejpeg($newImg,$newfilename);
				break;
			case 3: imagepng($newImg,$newfilename);
				break;
			default:  trigger_error('Failed resize image!', E_USER_WARNING);
				break;
		}

		return $newfilename;
	}

	public static function addWatermark($source, $watermark) {
		$image = self::_openImage($source);
		$wm = self::_openImage($watermark);

		if (!$image || !$wm) {
			return false;
		}

		$image = self::_create_watermark($image, $wm);
		$type = explode('.', $source);
		$type = array_pop($type);

		switch ($type) {
			case 'gif':
				imagegif($image, $source, 90);
				break;
			case 'jpg':
				imagejpeg($image, $source, 90);
				break;
			case 'jpeg':
				imagejpeg($image, $source, 90);
				break;
			case 'jpe':
				imagejpeg($image, $source, 90);
				break;
			case 'png':
				imagepng($image, $source, 90);
				break;
		}
	}

	private static function _saveImage($desc, $image, $type) {
		switch ($type) {
			case 'gif':
				imagegif($image, $dest, 90);
				break;
			case 'jpg':
				imagejpeg($image, $dest, 90);
				break;
			case 'jpeg':
				imagejpeg($image, $dest, 90);
				break;
			case 'jpe':
				imagejpeg($image, $dest, 90);
				break;
			case 'png':
				imagepng($image, $dest, 90);
				break;
		}
	}

	/**
	 *
	 * @param string $imagePath
	 * @return resource an image resource identifier on success, false on errors.
	 */
	private static function _openImage($imagePath) {
		$type = explode('.', $imagePath);
		$type = array_pop($type);
		switch ($type) {
			case 'gif':
				$image = imagecreatefromgif($imagePath);
				break;
			case 'jpg':
				$image = imagecreatefromjpeg($imagePath);
				break;
			case 'jpeg':
				$image = imagecreatefromjpeg($imagePath);
				break;
			case 'jpe':
				$image = imagecreatefromjpeg($imagePath);
				break;
			case 'png':
				$image = imagecreatefrompng($imagePath);
				break;
		}
		return $image;
	}

	private static function _create_watermark($main_img_obj, $watermark_img_obj, $alpha_level = 100) {
		$alpha_level/= 100;

		$main_img_obj_w = imagesx($main_img_obj);
		$main_img_obj_h = imagesy($main_img_obj);

		$watermark_img_obj_w = imagesx($watermark_img_obj);
		$watermark_img_obj_h = imagesy($watermark_img_obj);

		$main_img_obj_min_x = floor(( $main_img_obj_w - 10 ) - ( $watermark_img_obj_w ));
		$main_img_obj_max_x = ceil(( $main_img_obj_w - 10 ) + ( $watermark_img_obj_w ));
		$main_img_obj_min_y = floor(( $main_img_obj_h - 10 ) - ( $watermark_img_obj_h));
		$main_img_obj_max_y = ceil(( $main_img_obj_h - 10 ) + ( $watermark_img_obj_h));

		$return_img = imagecreatetruecolor($main_img_obj_w, $main_img_obj_h);

		for ($y = 0; $y < $main_img_obj_h; $y++) {
			for ($x = 0; $x < $main_img_obj_w; $x++) {
				$return_color = NULL;

				$watermark_x = $x - $main_img_obj_min_x;
				$watermark_y = $y - $main_img_obj_min_y;

				$main_rgb = imagecolorsforindex($main_img_obj, imagecolorat($main_img_obj, $x, $y));


				if ($watermark_x >= 0 && $watermark_x < $watermark_img_obj_w &&
						$watermark_y >= 0 && $watermark_y < $watermark_img_obj_h) {
					$watermark_rbg = imagecolorsforindex($watermark_img_obj, imagecolorat($watermark_img_obj, $watermark_x, $watermark_y));


					$watermark_alpha = round(( ( 127 - $watermark_rbg['alpha'] ) / 127 ), 2);
					$watermark_alpha = $watermark_alpha * $alpha_level;


					$avg_red = self::_get_ave_color($main_rgb['red'], $watermark_rbg['red'], $watermark_alpha);
					$avg_green = self::_get_ave_color($main_rgb['green'], $watermark_rbg['green'], $watermark_alpha);
					$avg_blue = self::_get_ave_color($main_rgb['blue'], $watermark_rbg['blue'], $watermark_alpha);


					$return_color = self::_get_image_color($return_img, $avg_red, $avg_green, $avg_blue);

				} else {
					$return_color = imagecolorat($main_img_obj, $x, $y);
				}
				imagesetpixel($return_img, $x, $y, $return_color);
			}
		}
		return $return_img;
	}

	protected static function _get_ave_color($color_a, $color_b, $alpha_level) {
		return round(( ( $color_a * ( 1 - $alpha_level ) ) + ( $color_b * $alpha_level ) ));
	}

	protected static function _get_image_color($im, $r, $g, $b) {
		$c = imagecolorexact($im, $r, $g, $b);
		if ($c != 1) return $c;
		$c = imagecolorallocate($im, $r, $g, $b);
		if ($c != 1) return $c;
		return imagecolorclosest($im, $r, $g, $b);
	}
}
