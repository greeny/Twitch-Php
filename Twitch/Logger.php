<?php
/**
 * @author Tomáš Blatný
 */

namespace greeny\Twitch;

class Logger {

	protected $requests = array();

	/**
	 * @param string    $target
	 * @param string    $method
	 * @param array     $headers
	 * @param array     $args
	 * @param float     $time
	 * @param \stdClass $response
	 */
	public function logRequest($target, $method, $headers, $args, $time, $response)
	{
		$request = array();

		$request['target'] = $target;
		$request['method'] = $method;
		$request['headers'] = $headers;
		$request['args'] = $args;
		$request['time'] = number_format($time, 1, '.', ' ') . ' ms';
		$request['ms'] = $time;
		$request['response'] = $response;
		$trace = debug_backtrace();
		$request['trace'] = $trace[2]['function'] !== 'sendRequest' ? $trace[2] : $trace[3];
		$this->requests[] = $request;
	}

	/**
	 * @return array
	 */
	public function getRequests()
	{
		return $this->requests;
	}

	/**
	 * @return string
	 */
	public function getTotalTime()
	{
		$total = 0;
		foreach($this->getRequests() as $request) {
			$total += $request['ms'];
		}
		return number_format($total, 1, '.', ' ') . ' ms';
	}
}
 