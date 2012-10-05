<?php
namespace Core;

class Lang extends \Laravel\Lang {

	/**
	 * Load a language array from a language file.
	 *
	 * @param  string  $bundle
	 * @param  string  $language
	 * @param  string  $file
	 * @return array
	 */
	public static function file($bundle, $language, $file)
	{
		$lines = array();

		// Language files can belongs to the application or to any bundle
		// that is installed for the application. So, we'll need to use
		// the bundle's path when looking for the file.
		$path = static::path($bundle, $language, $file);

		if (file_exists($path))
		{
			$lines = require $path;
		}
		else
		{
			$path = static::path($bundle, $language, $file, 'yml');
			$parser = IoC::resolve('yaml_parser');
			file_exists($path) && $lines = $parser->parse(file_get_contents($path));
		}

		return $lines;
	}

	/**
	 * Get the path to a bundle's language file.
	 *
	 * @param  string  $bundle
	 * @param  string  $language
	 * @param  string  $file
	 * @param  string  $ext
	 * @return string
	 */
	protected static function path($bundle, $language, $file, $ext = null)
	{
		$ext = $ext ? '.'.$ext : EXT;
		return Bundle::path($bundle)."language/{$language}/{$file}".$ext;
	}
}
