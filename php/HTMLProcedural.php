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

	public function contents()
	{
		return $this->contents;
	}

	public function clear()
	{
		$this->contents = '';
	}

	public function render()
	{
		echo $this->contents;
		$this->clear();
	}

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