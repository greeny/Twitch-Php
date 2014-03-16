<?php
/**
 * @author Tomáš Blatný
 */

namespace greeny\Twitch\Entities;

use greeny\Twitch\Api;
use greeny\Twitch\Helpers;

class User extends Entity {
	/** @var bool */
	protected $staff = FALSE;

	/** @var int */
	protected $id;

	/** @var string */
	protected $name;

	/** @var string */
	protected $displayName;

	/** @var string */
	protected $logo;

	/** @var \DateTime */
	protected $created;

	/** @var \DateTime */
	protected $updated;

	public function __construct(Api $api, $data)
	{
		if($data !== NULL) {
			$this->staff = $data->staff;
			$this->id = $data->_id;
			$this->name = $data->name;
			$this->displayName = $data->display_name;
			$this->logo = $data->logo;
			$this->created = Helpers::createDate($data->created_at);
			$this->updated = Helpers::createDate($data->updated_at);
		}
		parent::__construct($api, $data);
	}

	/**
	 * @return bool
	 */
	public function isStaff()
	{
		return $this->staff;
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
	public function getLogo()
	{
		return $this->logo;
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
	 * @param string|Channel $channelName
	 * @return bool
	 */
	public function isFollowingChannel($channelName)
	{
		if($channelName instanceof Channel) {
			$channelName = $channelName->getName();
		}
		return $this->api->isUserFollowingChannel($this->getName(), $channelName);
	}
}
 