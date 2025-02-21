<?php

class ofc_tags
{
	public function __construct()
	{
		$this->type      = "tags";
		$this->values	= array();
	}
	
	public function colour( $colour )
	{
		$this->colour = $colour;
		return $this;
	}
	
	/**
	 *@param $font as string. e.g. "Verdana"
	 *@param $size as integer. Size in px
	 */
	public function font($font, $size)
	{
		$this->font = $font;
		$this->{'font-size'} = $size;
		return $this;
	}

	/**
	 *@param $x as integer. Size of x padding in px
	 *@param $y as integer. Size of y padding in px
	 */
	public function padding($x, $y)
	{
		$this->{"pad-x"} = $x;
		$this->{"pad-y"} = $y;
		return $this;
	}
	
	public function rotate($angle)
	{
		$this->rotate($angle);
		return $this;
	}
	
	public function align_x_center()
	{
		$this->{"align-x"} = "center";
		return $this;
	}
	
	public function align_x_left()
	{
		$this->{"align-x"} = "left";
		return $this;
	}
	
	public function align_x_right()
	{
		$this->{"align-x"} = "right";
		return $this;
	}
	
	public function align_y_above()
	{
		$this->{"align-y"} = "above";
		return $this;
	}
	
	public function align_y_below()
	{
		$this->{"align-y"} = "below";
		return $this;
	}
	
	public function align_y_center()
	{
		$this->{"align-y"} = "center";
		return $this;
	}
	
	/**
	 * This can contain some HTML, e.g:
	 *  - "More <a href="javascript:alert(12);">info</a>"
	 *  - "<a href="http://teethgrinder.co.uk">ofc</a>"
	 */
	public function text($text)
	{
		$this->text = $text;
		return $this;
	}
	
	/**
	 * This works, but to get the mouse pointer to change
	 * to a little hand you need to use "<a href="">stuff</a>"-- see text()
	 */
	public function on_click($on_click)
	{
		$this->{'on-click'} = $on_click;
		return $this;
	}
	
	/**
	 *@param $bold boolean.
	 *@param $underline boolean.
	 *@param $border boolean.
	 *@prarm $alpha real (0 to 1.0)
	 */
	public function style($bold, $underline, $border, $alpha )
	{
		$this->bold = $bold;
		$this->border = $underline;
		$this->underline = $border;
		$this->alpha = $alpha;
		return $this;
	}
	
	/**
	 *@param $tag as ofc_tag
	 */
	public function append_tag($tag)
	{
		$this->values[] = $tag;
	}
}

class ofc_tag extends ofc_tags
{
	public function __construct($x, $y)
	{
		$this->x = $x;
		$this->y = $y;
	}
}