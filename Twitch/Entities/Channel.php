<?php
/**
 * @author Tomáš Blatný
 */

namespace greeny\Twitch\Entities;

use greeny\Twitch\Api;
use greeny\Twitch\Helpers;

class Channel extends Entity {
	/** @var bool */
	protected $mature = FALSE;

	/** @var string */
	protected $status = NULL;

	/** @var string */
	protected $game = NULL;

	/** @var int  */
	protected $id = NULL;

	/** @var string */
	protected $displayName = NULL;

	/** @var string */
	protected $name = NULL;

	/** @var \DateTime */
	protected $created = NULL;

	/** @var \DateTime */
	protected $updated = NULL;

	/** @var string */
	protected $logo = NULL;

	/** @var string */
	protected $banner = NULL;

	/** @var string */
	protected $videoBanner = NULL;

	/** @var string */
	protected $background = NULL;

	/** @var string */
	protected $url = NULL;

	/** @var Team[] */
	protected $teams = NULL;

	public function __construct(Api $api, $data)
	{
		if($data !== NULL) {
			$this->mature = $data->mature;
			$this->status = $data->status;
			$this->game = $data->game;
			$this->id = $data->_id;
			$this->displayName = $data->display_name;
			$this->name = $data->name;
			$this->created = Helpers::createDate($data->created_at);
			$this->updated = Helpers::createDate($data->updated_at);
			$this->logo = $data->logo;
			$this->banner = $data->banner;
			$this->videoBanner = $data->video_banner;
			$this->background = $data->background;
			$this->url = $data->url;
			$teams = array();
			foreach($data->teams as $team) {
				$teams[] = new Team($api, $team);
			}
			$this->teams = $teams;
			unset($data->teams);
		}
		parent::__construct($api, $data);
	}

	/**
	 * @return string
	 */
	public function getStatus()
	{
		return $this->status;
	}

	/**
	 * @return string
	 */
	public function getGame()
	{
		return $this->game;
	}

	/**
	 * @return bool
	 */
	public function isMature()
	{
		return $this->mature;
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
	public function getName()
	{
		return $this->name;
	}

	/**
	 * @return string
	 */
	public function getDisplayName()
	{
		return $this->displayName;
	}

	/**
	 * @return \DateTime
	 */
	public function getCreatedDate()
	{
		return $this->created;
	}

	/**
	 * @return \DateTime
	 */
	public function getUpdatedDate()
	{
		return $this->updated;
	}

	/**
	 * @return string
	 */
	public function getLogo()
	{
		return $this->logo;
	}

	/**
	 * @return string
	 */
	public function getBanner()
	{
		return $this->banner;
	}

	/**
	 * @return string
	 */
	public function getVideoBanner()
	{
		return $this->videoBanner;
	}

	/**
	 * @return string
	 */
	public function getBackground()
	{
		return $this->background;
	}

	/**
	 * @return string
	 */
	public function getUrl()
	{
		return $this->url;
	}

	/**
	 * @return Team[]
	 */
	public function getTeams()
	{
		return $this->teams;
	}

	/**
	 * @param int $page
	 * @return Video[]
	 */
	public function getVideos($page = 1)
	{
		return $this->api->getVideosInChannel($this->getName(), $page);
	}

	/**
	 * @param int $page
	 * @return User[]
	 */
	public function getFollows($page = 1)
	{
		return $this->api->getUsersFollowingChannel($this->getName(), $page);
	}

	/**
	 * @param string|User $userName
	 * @return bool
	 */
	public function isUserFollowing($userName)
	{
		return $this->api->isUserFollowingChannel($userName, $this->getName());
	}
}
 