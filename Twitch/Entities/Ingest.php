<?php
/**
 * @author Tomáš Blatný
 */

namespace greeny\Twitch\Entities;

use greeny\Twitch\Api;

class Ingest extends Entity {
	/** @var bool */
	protected $default;

	/** @var string */
	protected $name;

	/** @var int */
	protected $id;

	/** @var string */
	protected $urlTemplate;

	/** @var double */
	protected $availability;

	public function __construct(Api $api, $data)
	{
		if($data !== NULL) {
			$this->default = $data->default;
			$this->name = $data->name;
			$this->id = $data->_id;
			$this->urlTemplate = $data->url_template;
			$this->availability = (double)$data->availability;
		}
		parent::__construct($api, $data);
	}

	/**
	 * @return bool
	 */
	public function isDefault()
	{
		return $this->default;
	}

	/**
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * @return int
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * @return string
	 */
	public function getUrlTemplate()
	{
		return $this->urlTemplate;
	}

	/**
	 * @return float
	 */
	public function getAvailability()
	{
		return $this->availability;
	}

	/**
	 * @param string $streamKey
	 * @return mixed
	 */
	public function createUrl($streamKey)
	{
		return str_replace('{stream_key}', $streamKey, $this->getUrlTemplate());
	}
}
 