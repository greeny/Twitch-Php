<?php
/**
 * @author Tomáš Blatný
 */

namespace greeny\Twitch\Entities;

use greeny\Twitch\Api;

class Stream extends Entity {
	/** @var bool */
	protected $online = FALSE;

	/** @var int */
	protected $id = NULL;

	/** @var string */
	protected $name = NULL;

	/** @var string */
	protected $broadcaster = NULL;

	/** @var int */
	protected $viewers = NULL;

	/** @var string */
	protected $game = NULL;

	/** @var string */
	protected $preview = NULL;

	/** @var Channel */
	protected $channel = NULL;

	public function __construct(Api $api, $data)
	{
		if($data !== NULL) {
			$this->online = TRUE;
			$this->id = $data->_id;
			$this->broadcaster = $data->broadcaster;
			$this->name = $data->name;
			$this->viewers = $data->viewers;
			$this->game = $data->game;
			$this->preview = $data->preview;
			$this->channel = new Channel($api, $data->channel);
		}
		parent::__construct($api, $data);
	}

	/**
	 * @return int
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * @return bool
	 */
	public function isOnline()
	{
		return $this->online;
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
	public function getBroadcaster()
	{
		return $this->broadcaster;
	}

	/**
	 * @return int
	 */
	public function getViewers()
	{
		return $this->viewers;
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

	/**
	 * @return Channel
	 */
	public function getChannel()
	{
		return $this->channel;
	}
}
 