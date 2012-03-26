<?php
	class Eve_File {

		/**
		 *	Move file
		 * @param string $from
		 * @param string $to
		 * @return bool
		 */
		public static function move($from, $to) {
			if (file_exists($from)) {
				copy($from, $to);
				return self::unlink($from);
			} else {
				return false;
			}
		}

		/**
		 *	Alias for Eve_File::move()
		 * @param string $from
		 * @param string $to
		 * @return bool
		 */
		public function rename($from, $to) {
			self::move($from, $to);
		}

		/**
		 *	Permanently delete the file
		 * @param string $file
		 */
		public static function unlink($file) {
			if (file_exists($file)) {
				unlink($file);
			}
		}

		/**
		 * See unlink
		 * Alias for Eve_File::unlink()
		 *
		 * @param string $file
		 */
		public static function delete($file){
			self::delete($file);
		}

		/**
		 * Generate random file name
		 *
		 * @param strin $file Name file
		 * @return string
		 */
		public static function makeName($file) {
			$name = basename($file);
			$splitted = explode('.', $file);
			$ext = array_pop($splitted);

			$newName = md5(time().rand(1000, 9999));

			$newName = substr($newName, 1, 8);

			return $newName.'.'.$ext;
		}

		public static function getFiles($dir, $includeDirs = true) {
			$dir = opendir($dir);
			$files = array();

			while ($file = readdir($dir)) {
				if (is_dir($file) && !$includeDirs)
					continue;
				
				$files[] = $file;
			}

			return $files;
		}

	}