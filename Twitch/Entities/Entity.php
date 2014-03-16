<?php
/**
 * @author Tomáš Blatný
 */

namespace greeny\Twitch\Entities;

use greeny\Twitch\Api;

class Entity {
	/** @var \stdClass */
	protected $data = NULL;

	protected $api;

	public function __construct(Api $api, $data)
	{
		$this->api = $api;
		$this->data = $data;
	}

	/**
	 * @return \stdClass
	 */
	public function getRaw()
	{
		return $this->data;
	}
}
 