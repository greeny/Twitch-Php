<?php
/**
 * @author Tomáš Blatný
 */

namespace greeny\Twitch\Entities;

use greeny\Twitch\Api;
use greeny\Twitch\Helpers;

class Video extends Entity {
	/** @var string */
	protected $title = NULL;

	/** @var \DateTime */
	protected $recorded = NULL;

	/** @var string */
	protected $url = NULL;

	/** @var string */
	protected $id = NULL;

	/** @var string */
	protected $embed = NULL;

	/** @var int */
	protected $views = NULL;

	/** @var string */
	protected $description = NULL;

	/** @var int */
	protected $length = NULL;

	/** @var string */
	protected $game = NULL;

	/** @var string */
	protected $preview = NULL;

	public function __construct(Api $api, $data)
	{
		if($data !== NULL) {
			$this->title = $data->title;
			$this->recorded = Helpers::createDate($data->recorded_at);
			$this->url = $data->url;
			$this->id = $data->_id;
			$this->embed = $data->embed;
			$this->views = $data->views;
			$this->description = $data->description;
			$this->length = $data->length;
			$this->game = $data->game;
			$this->preview = $data->preview;
		}
		parent::__construct($api, $data);
	}

	/**
	 * @return string
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * @return string
	 */
	public function getTitle()
	{
		return $this->title;
	}

	/**
	 * @return \DateTime
	 */
	public function getRecordedDate()
	{
		return $this->recorded;
	}

	/**
	 * @return string
	 */
	public function getUrl()
	{
		return $this->url;
	}

	/**
	 * @return string
	 */
	public function getEmbed()
	{
		return $this->embed;
	}

	/**
	 * @return int
	 */
	public function getViews()
	{
		return $this->views;
	}

	/**
	 * @return string
	 */
	public function getDescription()
	{
		return $this->description;
	}

	/**
	 * @return int
	 */
	public function getLength()
	{
		return $this->length;
	}

	/**
	 * @return string
	 */
	public function getGame()
	{
		return $this->game;
	}

	/**
	 * @return string
	 */
	public function getPreview()
	{
		return $this->preview;
	}
}
 