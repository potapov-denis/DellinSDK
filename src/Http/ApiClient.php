<?php
/*
 * *
 *  * This code is licensed under the MIT License.
 *  *
 *  * Copyright (c) 2022 Denis Potapov (https://yooogi.ru)
 *  *
 *  * Permission is hereby granted, free of charge, to any person obtaining a copy
 *  * of this software and associated documentation files (the "Software"), to deal
 *  * in the Software without restriction, including without limitation the rights
 *  * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 *  * copies of the Software, and to permit persons to whom the Software is
 *  * furnished to do so, subject to the following conditions:
 *  *
 *  * The above copyright notice and this permission notice shall be included in
 *  * all copies or substantial portions of the Software.
 *  *
 *  * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 *  * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 *  * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 *  * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 *  * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 *  * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 *  * THE SOFTWARE.
 *
 */

declare(strict_types=1);

namespace Yooogi\DellinSDK\Http;

use Exception;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Promise\Utils as PromiseUtils;
use GuzzleHttp\Psr7\Query;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\UploadedFile;
use GuzzleHttp\Psr7\Utils as PsrUtils;
use GuzzleHttp\Utils;
use JsonSerializable;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\MessageInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Psr\Log\LoggerInterface;
use Yooogi\DellinSDK\Core\Arrayable;
use Yooogi\DellinSDK\Exceptions\BadRequest;
use Yooogi\DellinSDK\Exceptions\ServerFault;
use Yooogi\DellinSDK\Instantiator;


final class ApiClient implements LoggerAwareInterface
{
	use LoggerAwareTrait;

	private const API_URL = 'https://api.dellin.ru';

	/** @var ClientInterface */
	private $httpClient;
	private string $message = '';

	public function __construct(ClientInterface $httpClient, LoggerInterface $logger)
	{

		$this->httpClient = $httpClient;
		$this->logger = $logger;
	}

	public function get(string $path, ?Arrayable $request = null, $type = null, $async = false)
	{
		return $this->send('GET', ...func_get_args());
	}

	/**
	 * Выполнение запроса.
	 *
	 * @param string $method
	 * @param string $path
	 * @param Arrayable|array|null $requests
	 * @param mixed $responseType
	 * @param bool $async
	 *
	 * @return mixed
	 * @throws Exception
	 */
	private function send(string $method, string $path, Arrayable|array $requests = null, $responseType = null, bool $async = false): mixed
	{

		$method = strtoupper($method);
		try {


			if ($async === true && is_array($requests)) {
				$content = $this->sendAsync($method, $path, $requests);


			} else {
				$content = $this->sendSync($method, $path, $requests);
			}


			if (isset($content['errors'])) {
				if (is_array($content['errors'])) {
					foreach ($content['errors'] as $key => $error) {
						if (!is_array($error)) {
							$this->message .= $key . ' ' . $error . ' ';
							$this->message .= PHP_EOL;
						}

					}
				} else {
					$this->message = $content['errors'] . ' ';
				}
				throw new BadRequest($this->message);
			}


			if (count($content) > 0) {
				return $responseType === null
					? $content
					: Instantiator::instantiate($responseType, $content);
			}


			throw new BadRequest();
		} catch (ClientException $e) {
			throw $this->handleClientException($e);
		} catch (ServerException $e) {
			throw $this->handleServerException($e);
		} catch (Exception $e) {
			$this->logException($e->getCode(), $e->getMessage());
			throw $e;

		}
	}

	private function sendAsync(string $method, string $path, $requests)
	{

		$content = [];
		foreach ($requests as $key => $request) {

			$promises[$key] = $this->httpClient->sendAsync($this->buildHttpRequest($method, $path, $request))
				->then(
					function (ResponseInterface $response) use (&$content, $key) {
						$contentType = $response->getHeaderLine('Content-Type');
						if (preg_match('~^application/(pdf|zip)$~', $contentType, $matches)) {
							return $this->buildFile($response, $matches[1]);
						}

						if (preg_match('~^application/json~', $contentType)) {
							$content[$key] = $this->getResponseContent($response);
							$this->logger->info("Dellin response: status={$response->getStatusCode()}", $this->getResponseContent($response));

						}

						return $content;

					}
				);
		}

		$results = PromiseUtils::settle($promises)->wait();


		foreach ($results as $key => $result) {
			if ($result['state'] == 'rejected') {
				$e = new ClientException('' . $key . '', $result['reason']->getRequest(), $result['reason']->getResponse(), $e ?? null);
			}
			if ($result['state'] == 'fulfilled') {
				return $content;
			}
		}


		throw $this->handleClientException($e);
	}

	private function buildHttpRequest(string $method, string $path, Arrayable|array $payload): RequestInterface|MessageInterface
	{

		$payload = $payload->toArray();
		$request = new Request($method, self::API_URL . $path, ['Accept' => 'application/json;charset=UTF-8']);

		if ($payload === null) {
			$this->logger->info("Dellin request: {$path}");

			return $request;
		}

		$data = $this->serializeRequestData($payload);


		$this->logger->info("Dellin request: {$path}", $data);

		if ($method === 'GET') {
			return PsrUtils::modifyRequest($request, ['query' => Query::build($data)]);
		}
		return $request
			->withHeader('Content-Type', 'application/json;charset=UTF-8')
			->withBody(PsrUtils::streamFor(Utils::jsonEncode($data)));
	}

	private function serializeRequestData(array $data): array
	{
		return array_map(function ($value) {
			if (is_object($value) && $value instanceof JsonSerializable) {
				return $value->jsonSerialize();
			}

			if (is_array($value)) {
				return $this->serializeRequestData($value);
			}

			return $value;
		}, $data);
	}

	private function buildFile(ResponseInterface $response, string $type): UploadedFile
	{
		preg_match('~=(.+)$~', $response->getHeaderLine('Content-Disposition'), $matches);

		$fileName = "{$matches[1]}.{$type}";
		$fileSize = $response->getBody()->getSize();

		$this->logger->info(vsprintf('Dellin response: status=%s, file=%s, size=%s bytes', [
			$response->getStatusCode(),
			$fileName,
			$fileSize,
		]));

		return new UploadedFile(
			$response->getBody(), $fileSize, UPLOAD_ERR_OK, $fileName, $response->getHeaderLine('Content-Type')
		);
	}

	private function getResponseContent(ResponseInterface $response): array
	{
		return Utils::jsonDecode((string)$response->getBody(), true);
	}

	private function handleClientException(ClientException $exception): BadRequest
	{

		$multiple = (bool)$exception->getPrevious();

		do {
			$content = $this->getResponseContent($exception->getResponse());

			$this->logException($exception->getCode(), $exception->getMessage(), $content);

			if (isset($content['errors'])) {
				if (is_array($content['errors'])) {
					foreach ($content['errors'] as $error) {
						$this->message = (is_array($error['fields'])) ? implode(' ', $error['fields']) . ' ' : $error['fields'] . ' ';
						$this->message .= (isset($error['detail'])) ? $error['detail'] . ' ' : '';
						$this->message .= (isset($error['title'])) ? $error['title'] . '. ' : '';

						$code = $exception->getCode();

						$message = ($multiple) ? $exception->getMessage() . ' ' . $this->message : $this->message;
						$e = new Exception($message, $code, $e ?? null);

					}
				} else {
					$e = new Exception($content['errors']);
				}
			}

			if (isset($content['error'])) {
				$e = new Exception($content['error']['description']);
			}
		} while ($exception = $exception->getPrevious());


		return new BadRequest(
			$e->getMessage() ?? '',
			isset($content['metadata']['status']) ? (int)$content['metadata']['status'] : $e->getCode(),
			$e->getPrevious()
		);
	}

	private function logException(int $status, string $message, array $data = []): void
	{
		$this->logger->error("code=$status, $message", $data);
	}

	private function sendSync(string $method, string $path, $request)
	{


		$response = $this->httpClient->send($this->buildHttpRequest($method, $path, $request));


		$contentType = $response->getHeaderLine('Content-Type');

		if (preg_match('~^application/(pdf|zip)$~', $contentType, $matches)) {
			return $this->buildFile($response, $matches[1]);
		}

		if (preg_match('~^application/json~', $contentType)) {
			$content = $this->getResponseContent($response);
			$this->logger->info("Dellin response: status={$response->getStatusCode()}", $content);

		}

		return $content;

	}

	private function handleServerException(ServerException $exception): ServerFault
	{
		return new ServerFault($exception->getMessage(), $exception->getCode(), $exception);
	}

	public function post(string $path, Arrayable|array $request, $type = null, $async = false)
	{
		return $this->send('POST', ...func_get_args());
	}

	public function put(string $path, Arrayable $request, $type = null, $async = false)
	{
		return $this->send('PUT', ...func_get_args());
	}

	public function delete(string $path, Arrayable $request, $type = null, $async = false)
	{
		return $this->send('DELETE', ...func_get_args());
	}
}
