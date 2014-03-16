<?php
/**
 * @author Tomáš Blatný
 */

namespace greeny\Twitch;

class Helpers {
	/**
	 * @param string $string
	 * @return \DateTime
	 */
	public static function createDate($string)
	{
		return date_create_from_format('Y-m-d*H:i:s*', $string);
	}

	/**
	 * @param int $page
	 * @param int $itemsPerPage
	 * @return array
	 */
	public static function buildPageArgs($page, $itemsPerPage)
	{
		return array(
			'limit' => $itemsPerPage,
			'offset' => ($page - 1) * $itemsPerPage,
		);
	}

	/**
	 * @param string $query
	 * @return string
	 */
	public static function encodeQuery($query)
	{
		return urlencode($query);
	}
}
 