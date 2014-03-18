<?php
/**
 * @author Tomáš Blatný
 */

require_once __DIR__ . "/exceptions.php";

spl_autoload_register(function ($type) {
	static $paths = array(
		'greeny\twitch\api' => 'Api.php',
		'greeny\twitch\helpers' => 'Helpers.php',
		'greeny\twitch\logger' => 'Logger.php',
		'greeny\twitch\entities\channel' => 'Entities/Channel.php',
		'greeny\twitch\entities\emoticon' => 'Entities/Emoticon.php',
		'greeny\twitch\entities\entity' => 'Entities/Entity.php',
		'greeny\twitch\entities\featuredstream' => 'Entities/FeaturedStream.php',
		'greeny\twitch\entities\game' => 'Entities/Game.php',
		'greeny\twitch\entities\stream' => 'Entities/Stream.php',
		'greeny\twitch\entities\team' => 'Entities/Team.php',
		'greeny\twitch\entities\user' => 'Entities/User.php',
		'greeny\twitch\entities\video' => 'Entities/Video.php',
	);

	$type = ltrim(strtolower($type), '\\'); // PHP namespace bug #49143

	if (isset($paths[$type])) {
		require_once __DIR__ . '/' . $paths[$type];
	}
});