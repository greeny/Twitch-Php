<?php
/**
 * @author Tomáš Blatný
 */

namespace greeny\Twitch\Entities;

use greeny\Twitch\Api;

class FeaturedStream extends Stream {

	/** @var string */
	protected $image;

	/** @var string */
	protected $text;

	public function __construct(Api $api, $data)
	{
		if($data !== NULL) {
			$this->image = $data->image;
			$this->text = $data->text;
		}
		parent::__construct($api, $data->stream);
	}

	/**
     * @return string
     */
	public function getImage()
	{
		return $this->image;
	}

	/**
	 * @return string
	 */
	public function getText()
	{
		return $this->text;
	}
}
 