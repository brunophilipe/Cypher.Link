<?php

class HTMLProcedural
{
	private $contents = "";

	public function append($string)
	{
		$this->contents .= $string;
	}

	public function wrap($tag, $classes = null, $id = null, $extras = null)
	{
		$contents = $this->contents;
		$this->clear();
		$this->append(factory($tag, $contents, $classes, $id, $extras));
	}

	/**
	 * Returns the accumulated contents (using `append()`) of this objects. To print the contents directly,
	 * see `render()`.
	 */
	public function contents()
	{
		return $this->contents;
	}

	/**
	 * Erases the accumulated content of this object by setting it to an empty array.
	 */
	public function clear()
	{
		$this->contents = '';
	}

	/**
	 * Prints the contents of this object using echo. To get the contents as a variable, see `contents()`.
	 */
	public function render()
	{
		echo $this->contents;
		$this->clear();
	}

	/**
	 * Generates a tag as a string. To create a tag without a closing element (e.g. `<input type="text" />` pass
	 * contents = null.
	 *
	 * See `factory_a(6)` to generate inline link tags and `factory_img(4)` to generate image tags.
	 *
	 * @param string $tag The name of the tag to be generated. For example: "div", "input", or "p".
	 * @param string $contents The contents of the tag to be generated.
	 * @param array=null $classes List of strings with the classes to be set in this tag.
	 * @param string=null $id The ID of this tag.
	 * @param array=null $extras Extra attributes to add to this tag. For example: `array("href"=>"/home", "readonly")`.
	 *
	 * @return string The generated tag as a string. For example: `<a href="/home">Go Home</a>`.
	 */
	static public function factory($tag, $contents, $classes = null, $id = null, $extras = null)
	{
		$element = '<'.$tag;

		if (!is_null($classes) && count($classes))
		{
			$element .= ' class="';
			foreach ($classes as $class)
			{
				$element .= $class." ";
			}

			$element .= '"';
		}

		if (!is_null($id))
		{
			$element .= ' id="'.$id.'"';
		}

		if (!is_null($extras) && count($extras))
		{
			foreach ($extras as $extra => $value)
			{
				if (is_string($extra))
				{
					$element .= ' '.$extra.'="'.$value.'"';
				} else {
					$element .= ' '.$value;
				}
			}
		}

		if (!is_null($contents))
		{
			$element .= '>';
			$element .= $contents;
			$element .= '</'.$tag.'>';
		} else {
			$element .= ' />';
		}

		return $element;
	}

	/**
	 * @param string $src The source of the image tag to be generated.
	 * @param string $alt The alternative text for this image. The default value is an empty string.
	 * @param null $classes
	 * @param null $id
	 * @return string
	 */
	static public function factory_img($src, $alt = "", $classes = null, $id = null)
	{
		$extras = array("src"=>$src, "alt"=>$alt);
		return HTMLProcedural::factory("a", null, $classes, $id, $extras);
	}

	static public function factory_a($content, $href, $target = null, $classes = null, $id = null, $srcextras = null)
	{
		if (!is_null($srcextras) && !is_null($href))
		{
			$extras = array("href"=>$href);
			$extras = array_merge($extras, $srcextras);
		} else {
			$extras = $srcextras;
		}

		if (!is_null($target))
			$extras["target"] = $target;

		return HTMLProcedural::factory("a",$content, $classes, $id, $extras);
	}
}

function factory($tag, $contents, $classes = null, $id = null, $extras = null) {
	return HTMLProcedural::factory($tag, $contents, $classes, $id, $extras);
}

function factory_img($src, $alt = "", $classes = null, $id = null) {
	return HTMLProcedural::factory_img($src, $alt, $classes, $id);
}

function factory_a($content, $href, $target = null, $classes = null, $id = null, $extras = null) {
	return HTMLProcedural::factory_a($content, $href, $target, $classes, $id, $extras);
}