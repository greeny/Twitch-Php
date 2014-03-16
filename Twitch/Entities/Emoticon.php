<?php
/**
 * @author Tomáš Blatný
 */

namespace greeny\Twitch\Entities;

use greeny\Twitch\Api;

class Emoticon extends Entity {

	/** @var string */
	protected $regex;

	/** @var array */
	protected $images;

	public function __construct(Api $api, $data)
	{
		if($data !== NULL) {
			$this->regex = $data->regex;
			$this->images = array();
			foreach($data->images as $image) {
				$this->images[] = array(
					'emoticonSet' => $image->emoticonSet,
					'width' => $image->width,
					'height' => $image->height,
					'url' => $image->url,
				);
			}
		}
		parent::__construct($api, $data);
	}

	/**
	 * @return string
	 */
	public function getRegex()
	{
		return $this->regex;
	}

	/**
	 * @return array
	 */
	public function getImages()
	{
		return $this->images;
	}

	/**
	 * @param int $setId
	 * @return array|NULL
	 */
	public function getImageBySet($setId)
	{
		if(!count($this->images)) {
			return NULL;
		}
		$setId = (int) $setId;
		$default = NULL;
		foreach($this->images as $image) {
			if($image['emoticonSet'] === $setId) {
				return $image;
			} else if($image['emoticonSet'] === 0 && $default === NULL) {
				$default = $image;
			}
		}
		return $default !== NULL ? $default : $this->images[0];
	}
}
 