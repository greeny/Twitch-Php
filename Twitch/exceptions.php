<?php
/**
 * @author Tomáš Blatný
 */

namespace greeny\Twitch;

use Exception;

class TwitchException extends Exception {}

class ApiException extends TwitchException {}

class NotFoundException extends ApiException {}