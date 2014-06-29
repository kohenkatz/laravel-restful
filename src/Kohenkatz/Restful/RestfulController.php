<?php namespace Kohenkatz\Restful;

use \Controller;
use \Request;
use \Input;
use \Response;
use Kohenkatz\Restful\Util\XMLSerializer;


class RestfulController extends Controller {

	protected $defaultFormat = 'json';

	// List of mime types that the underlying Request doesn't support
	protected static $additional_formats = array(
		'jsonp' => 'application/javascript',
	);

	protected $statusCode = 200;

	public function __construct()
	{
		$this->afterFilter('@processResponse');
	}

	public function processResponse($route, $request, $response)
	{
		// Register the mime types that the underlying Request doesn't support
		foreach (static::$additional_formats as $ext => $mimes) {
			Request::setFormat($ext, $mimes);
		}

		if (is_array($response->original)) {
			$format = $this->getFormat();
			$content = $this->formatContent($response->original, $format);

			$response->setContent($content);
			$response->headers->set('Content-Type', Request::getMimeType($format));
		}
	}

	protected function formatContent(array $response, $format)
	{
		switch ($format)
		{
			// FIX THESE
			case 'json':  return json_encode($response);
			case 'jsonp': return Input::get('jsonp', 'jsonp').'('.json_encode($response).');';
			case 'xml':   return (new XMLSerializer)->generateValidXmlFromArray($response, 'root');
		}
	}

	/**
	 * Creates a response object from a string
	 * @param string $contents normally, a string that has been converted ready for outpu
	 * @param string $format
	 * @return type
	 */
	protected function createResponse($contents, $format)
	{
		$response = Response::make($contents, 200);
		$response->headers->set('Content-Type', Request::getMimeType($format));
		return $response;
	}

	/**
	 * Detects and returns the format
	 * @return string the format to output as
	 */
	public function getFormat() {

		// First, look at the query string
		// For example: ?format=json
		if (($format = Input::get('format', false)) !== false) {
			return $format;
		}

		// Then, look at the extension
		$name_parts = explode('.', Request::path());
		if (count($name_parts) > 1) {
			return end($name_parts);
		}

		// Finally, look at the `Accept` header
		// If this finds no result, the default will be used.
		return parent::format($this->defaultFormat);
	}
}
