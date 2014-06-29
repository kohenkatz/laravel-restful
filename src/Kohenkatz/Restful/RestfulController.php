<?php namespace Kohenkatz\Restful;

use \Controller;
use \Request;
use \Input;
use \Response;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;


class RestfulController extends Controller {

	protected $defaultFormat = 'json';

	protected $priority = array(
		'header',
		'extension',
		'querystring',
	);

	protected $formats = array(
		'xml' => 'application/xml',
		'json' => 'application/json',
		// 'jsonp' => 'application/javascript',
		// 'serialized' => 'application/vnd.php.serialized',
		// 'php' => 'text/plain',
		// 'html' => 'text/html',
		// 'csv' => 'application/csv'
	);

	protected $statusCode = 200;

	/**
	 * Process a controller action response.
	 *
	 * @param  \Illuminate\Routing\Router  $router
	 * @param  string  $method
	 * @param  mixed   $response
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	protected function processResponse($router, $method, $response)
	{
		if (is_array($response)) {
			$format = $this->getFormat();
			$content = $this->format($response, $format);

			$response = $this->createResponse($content, $format);
		}

		return parent::processResponse($router, $method, $response);
	}

	/**
	 * Set the HTTP status of the response.
	 * 
	 * Normally called from the controller action before returning.
	 * 
	 * @param int status
	 * @return RestfulController for chaining
	 */
	protected function status($status = null) {
		if ($status === null) {
			return $status;
		}

		$this->statusCode = $status;

		return $this;
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

		return $response->header('Content-Type', $this->formats[$format]);
	}

	/**
	 * Formats an array to a string in the supplied format
	 * 
	 * @param mixed array $response the output array
	 * @param string $type the format to convert to
	 * @return string the converted string
	 */
	protected function format(array $response, $type) {
		$encoders = $this->getEncoders();

		return (new Serializer(array(), $encoders))
			->serialize($response, $type);
	}

	protected function getEncoders() {
		return array(
			new XmlEncoder(),
			new JsonEncoder(),
		);
	}

	/**
	 * Detects and returns the format
	 * @return string the format to output as
	 */ 
	public function getFormat() {

		foreach ($this->priority as $type) {
			$format = $this->{'getFormatFrom'.ucwords($type)}();
			if ($format !== false) {
				return $format;
			}
		}

		return $this->getDefaultFormat();
	}

	/**
	 * Grabs the format from the querystring, for example: ?format=json 
	 * @return string | false
	 */
	public function getFormatFromQuerystring() {
		return Input::get('format', false);
	}

	/**
	 * Get the format from the extension of the path used
	 * @return string
	 */
	public function getFormatFromExtension() {
		$parts = explode('.', Request::path());

		if (count($parts) === 1) {
			return false;
		}

		return end($parts);
	}

	/**
	 * Get the format from the Accept header
	 */
	public function getFormatFromHeader() {
		Request::header('Content-Type');
		return false;
	}

	/**
	 * When no other format was specified, use this.
	 */
	public function getDefaultFormat() {
		return $this->defaultFormat;
	}
}
