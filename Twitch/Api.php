<?php
/**
 * @author Tomáš Blatný
 */

namespace greeny\Twitch;

use greeny\Twitch\Entities\Channel;
use greeny\Twitch\Entities\Emoticon;
use greeny\Twitch\Entities\FeaturedStream;
use greeny\Twitch\Entities\Game;
use greeny\Twitch\Entities\Ingest;
use greeny\Twitch\Entities\Stream;
use greeny\Twitch\Entities\Team;
use greeny\Twitch\Entities\User;
use greeny\Twitch\Entities\Video;

class Api {

	const METHOD_GET = 'GET';
	const METHOD_POST = 'POST';
	const METHOD_PUT = 'PUT';
	const METHOD_DELETE = 'DELETE';

	const PERIOD_WEEK = 'week';
	const PERIOD_MONTH = 'month';
	const PERIOD_ALL = 'all';

	/** @var string */
	public static $api = 'https://api.twitch.tv/kraken/';

	/** @var Logger */
	protected $logger;

	/** @var int */
	protected $itemsPerPage;

	public function __construct($itemsPerPage = 25)
	{
		$this->itemsPerPage = $itemsPerPage;
		$this->logger = new Logger();
	}

	/**
	 * @param string $channelName
	 * @return Channel
	 */
	public function getChannel($channelName)
	{
		return new Channel($this, $this->sendRequest('channels/'.$channelName));
	}

	/**
	 * @param string $game
	 * @param array  $channels
	 * @param int    $page
	 * @return Stream[]
	 */
	public function getStreams($game = NULL, array $channels = array(), $page = 1)
	{
		$search = array();
		if($game !== NULL) {
			$search['game'] = (string) $game;
		}

		if(count($channels)) {
			$ch = array();
			foreach($channels as $channel) {
				if($channel instanceof Channel) {
					$ch[] = $channel->getName();
				} else {
					$ch[] = (string) $channel;
				}
			}
			$search['channel'] = implode(',', $ch);
		}

		$response = $this->sendRequest('streams', self::METHOD_GET, array(), array_merge($search, $this->buildPageArgs($page)));
		$streams = array();
		foreach($response->streams as $stream) {
			$streams[] = new Stream($this, $stream);
		}
		return $streams;
	}

	/**
	 * @param int $page
	 * @return FeaturedStream[]
	 */
	public function getFeaturedStreams($page = 1)
	{
		$response = $this->sendRequest('streams/featured', self::METHOD_GET, array(), $this->buildPageArgs($page));
		$streams = array();
		foreach($response->featured as $featured) {
			$streams[] = new FeaturedStream($this, $featured);
		}
		return $streams;
	}

	/**
	 * @param string $channelName
	 * @return Stream
	 */
	public function getStream($channelName)
	{
		return new Stream($this, $this->sendRequest('streams/'.$channelName)->stream);
	}

	/**
	 * @return array
	 */
	public function getSummary()
	{
		$response = $this->sendRequest('streams/summary');
		return array(
			'viewers' => $response->viewers,
			'channels' => $response->channels,
		);
	}

	/**
	 * @param int $page
	 * @return Team[]
	 */
	public function getTeams($page = 1)
	{
		$response = $this->sendRequest('teams', self::METHOD_GET, array(), $this->buildPageArgs($page));
		$teams = array();
		foreach($response->teams as $team) {
			$teams[] = new Team($this, $team);
		}
		return $teams;
	}

	/**
	 * @param string $teamName
	 * @return Team
	 */
	public function getTeam($teamName)
	{
		return new Team($this, $this->sendRequest('teams/'.$teamName));
	}

	/**
	 * @param string $game
	 * @param string $period
	 * @param int    $page
	 * @return Video[]
	 */
	public function getVideos($game = NULL, $period = self::PERIOD_WEEK, $page = 1)
	{
		$search = array(
			'period' => $period,
		);
		if($game !== NULL) {
			$search['game'] = (string) $game;
		}
		$response = $this->sendRequest('videos/top', self::METHOD_GET, array(), array_merge($search, $this->buildPageArgs($page)));
		$videos = array();
		foreach($response->videos as $video) {
			$videos[] = new Video($this, $video);
		}
		return $videos;
	}

	/**
	 * @param string|Channel $channelName
	 * @param int            $page
	 * @return Video[]
	 */
	public function getVideosInChannel($channelName, $page = 1)
	{
		if($channelName instanceof Channel) {
			$channelName = $channelName->getName();
		}
		$response = $this->sendRequest("channels/$channelName/videos", self::METHOD_GET, array(), $this->buildPageArgs($page));
		$videos = array();
		foreach($response->videos as $video) {
			$videos[] = new Video($this, $video);
		}
		return $videos;
	}

	/**
	 * @param string|Channel $channelName
	 * @param int            $page
	 * @return User[]
	 */
	public function getUsersFollowingChannel($channelName, $page = 1)
	{
		if($channelName instanceof Channel) {
			$channelName = $channelName->getName();
		}
		$response = $this->sendRequest("channels/$channelName/follows", self::METHOD_GET, array(), $this->buildPageArgs($page));
		$users = array();
		foreach($response->follows as $follow) {
			$users[] = new User($this, $follow->user);
		}
		return $users;
	}

	/**
	 * @param string|User $userName
	 * @param int         $page
	 * @return Channel[]
	 */
	public function getChannelsFollowedByUser($userName, $page = 1)
	{
		if($userName instanceof User) {
			$userName = $userName->getName();
		}
		$response = $this->sendRequest("users/$userName/follows/channels", self::METHOD_GET, array(), $this->buildPageArgs($page));
		$channels = array();
		foreach($response->follows as $follow) {
			$channels[] = new Channel($this, $follow->channel);
		}
		return $channels;
	}

	/**
	 * @param string|User    $userName
	 * @param string|Channel $channelName
	 * @return bool
	 */
	public function isUserFollowingChannel($userName, $channelName)
	{
		if($userName instanceof User) {
			$userName = $userName->getName();
		}
		if($channelName instanceof Channel) {
			$channelName = $channelName->getName();
		}
		try {
			$this->sendRequest("users/$userName/follows/channels/$channelName");
			return TRUE;
		} catch(NotFoundException $e) {
			return FALSE;
		}
	}

	/**
	 * @param string $userName
	 * @return User
	 */
	public function getUser($userName)
	{
		return new User($this, $this->sendRequest("users/$userName"));
	}

	/**
	 * @return Emoticon[]
	 */
	public function getEmoticons()
	{
		$response = $this->sendRequest('chat/emoticons');
		$emoticons = array();
		foreach($response->emoticons as $emoticon) {
			$emoticons[] = new Emoticon($this, $emoticon);
		}
		return $emoticons;
	}

	/**
	 * @param int $page
	 * @return Game[]
	 */
	public function getGames($page = 1)
	{
		$response = $this->sendRequest('games/top', self::METHOD_GET, array(), $this->buildPageArgs($page));
		$games = array();
		foreach($response->top as $game) {
			$games[] = new Game($this, $game->game);
		}
		return $games;
	}

	/**
	 * @return Ingest[]
	 */
	public function getIngests()
	{
		$response = $this->sendRequest('ingests');
		$ingests = array();
		foreach($response->ingests as $ingest) {
			$ingests[] = new Ingest($this, $ingest);
		}
		return $ingests;
	}

	/**
	 * @param string $id
	 * @return Video
	 */
	public function getVideo($id)
	{
		return new Video($this, $this->sendRequest('videos/'.$id));
	}

	/**
	 * @param string $query
	 * @return Game[]
	 */
	public function searchGames($query)
	{
		$response = $this->sendRequest('search/games', self::METHOD_GET, array(), array(
			'query' => Helpers::encodeQuery($query),
			'type' => 'suggest',
		));
		$games = array();
		foreach($response->games as $game) {
			$games[] = new Game($this, $game);
		}
		return $games;
	}

	/**
	 * @param string $query
	 * @param int    $page
	 * @return Stream[]
	 */
	public function searchStreams($query, $page = 1)
	{
		$response = $this->sendRequest('search/streams', self::METHOD_GET, array(), array_merge(array('query' => Helpers::encodeQuery($query)), $this->buildPageArgs($page)));
		$streams = array();
		foreach($response->games as $stream) {
			$streams[] = new Stream($this, $stream);
		}
		return $streams;
	}

	/**
	 * @return Logger
	 */
	public function getLogger()
	{
		return $this->logger;
	}

	/**
	 * @param string $request
	 * @param string $method
	 * @param array  $headers
	 * @param array  $args
	 * @throws ApiException
	 * @return \stdClass
	 */
	protected function sendRequest($request, $method = self::METHOD_GET, $headers = array(), $args = array())
	{
		return $this->sendUrlRequest(self::$api . $request, $method, $headers, $args);
	}

	/**
	 * @param string $request
	 * @param string $method
	 * @param array  $headers
	 * @param array  $args
	 * @throws ApiException
	 * @return \stdClass
	 */
	protected function sendUrlRequest($request, $method = self::METHOD_GET, $headers = array(), $args = array())
	{
		$context = array(
			'http' => array(
				'ignore_errors' => TRUE,
				'method' => $method,
				'header' => array_merge(
					$headers,
					array(
						'Accept: application/vnd.twitchtv.v2+json',
					)
				),
			)
		);

		if(count($args)) {
			if($method !== self::METHOD_GET) {
				$context['http']['header'][] = 'Content-type: application/x-www-form-urlencoded';
				$context['http']['context'] = http_build_query($args, '', '&');
			} else {
				$request .= '?'.http_build_query($args, '', '&');
			}
		}

		$timer = microtime(TRUE);
		$response = json_decode(file_get_contents($request, FALSE, stream_context_create($context)));
		$time = (microtime(TRUE) - $timer) * 1000;
		$this->logger->logRequest($request, $method, $context['http']['header'], $args, $time, $response);

		if(isset($response->error)) {
			$message =  "$response->status $response->error: $response->message";
			$code = $response->status;
			if($code === 404) {
				throw new NotFoundException($message, $code);
			} else {
				throw new ApiException($message, $code);
			}
		}
		return $response;
	}

	/**
	 * @param int $page
	 * @return array
	 */
	protected function buildPageArgs($page)
	{
		$page = max((int)$page, 1);
		return Helpers::buildPageArgs($page, $this->itemsPerPage);
	}

}
 