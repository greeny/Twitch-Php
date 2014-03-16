<?php
/**
 * @author Tomáš Blatný
 */

namespace greeny\Twitch\Entities;

use greeny\Twitch\Api;

class Game extends Entity {
	/** @var string */
	protected $name;

	/** @var string */
	protected $box;

	/** @var string */
	protected $logo;

	/** @var int */
	protected $id;

	/** @var int */
	protected $viewers;

	/** @var int */
	protected $channels;

	/** @var int */
	protected $popularity;

	public function __construct(Api $api, $data)
	{
		if($data !== NULL) {
			$this->name = $data->name;
			$this->box = $data->box;
			$this->logo = $data->logo;
			$this->id = $data->_id;
			$this->viewers = $data->viewers;
		}
		parent::__construct($api, $data);
	}

	/**
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * @return string
	 */
	public function getBox()
	{
		return $this->box;
	}

	/**
	 * @return string
	 */
	public function getLogo()
	{
		return $this->logo;
	}

	/**
	 * @return int
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * @return int
	 */
	public function getViewers()
	{
		return $this->viewers;
	}

	/**
	 * @return int
	 */
	public function getChannels()
	{
		return $this->channels;
	}

	/**
	 * @return int
	 */
	public function getPopularity()
	{
		return $this->popularity;
	}

	/**
	 * @param array $channels
	 * @param int   $page
	 * @return Stream[]
	 */
	public function getStreams($channels = array(), $page = 1)
	{
		return $this->api->getStreams($this->getName(), $channels, $page);
	}

	/**
	 * @param string $period
	 * @param int    $page
	 * @return Video[]
	 */
	public function getVideos($period = Api::PERIOD_WEEK, $page = 1)
	{
		return $this->api->getVideos($this->getName(), $period, $page);
	}
}
 