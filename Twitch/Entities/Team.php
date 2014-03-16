<?php
/**
 * @author Tomáš Blatný
 */

namespace greeny\Twitch\Entities;

use greeny\Twitch\Api;
use greeny\Twitch\Helpers;

class Team extends Entity {
	/** @var int */
	protected $id = NULL;

	/** @var string */
	protected $name = NULL;

	/** @var string */
	protected $displayName = NULL;

	/** @var string */
	protected $info;

	/** @var \DateTime */
	protected $created = NULL;

	/** @var \DateTime */
	protected $updated = NULL;

	/** @var string */
	protected $logo = NULL;

	/** @var string */
	protected $banner = NULL;

	/** @var string */
	protected $background = NULL;

	public function __construct(Api $api, $data)
	{
		if($data !== NULL) {
			$this->id = $data->_id;
			$this->name = $data->name;
			$this->displayName = $data->display_name;
			$this->info = trim($data->info);
			$this->created = Helpers::createDate($data->created_at);
			$this->updated = Helpers::createDate($data->updated_at);
			$this->logo = $data->logo;
			$this->banner = $data->banner;
			$this->background = $data->background;
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
	 * @return string
	 */
	public function getInfo()
	{
		return $this->info;
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
	public function getBackground()
	{
		return $this->background;
	}
}
 