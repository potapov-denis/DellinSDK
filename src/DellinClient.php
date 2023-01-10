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

namespace Yooogi\DellinSDK;

use Psr\Http\Client\ClientInterface;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Yooogi\DellinSDK\Endpoints\Authorization\Authorization;
use Yooogi\DellinSDK\Endpoints\Book\Book;
use Yooogi\DellinSDK\Endpoints\Calculations\Calculations;
use Yooogi\DellinSDK\Endpoints\ManageOrders\ManageOrders;
use Yooogi\DellinSDK\Endpoints\Marking\Marking;
use Yooogi\DellinSDK\Endpoints\Orders\Orders;
use Yooogi\DellinSDK\Endpoints\OrdersInfo\OrdersInfo;
use Yooogi\DellinSDK\Endpoints\Services\Services;
use Yooogi\DellinSDK\Exceptions\UnknownEndpoint;
use Yooogi\DellinSDK\Http\ApiClient;

/**
 * @property-read  Orders $orders
 * @property-read  OrdersInfo $ordersInfo
 * @property-read  ManageOrders $manageOrders
 * @property-read  Calculations $calculations
 * @property-read  Authorization $authorization
 * @property-read  Services $services
 * @property-read  Book $book
 * @property-read  Marking $marking
 */
final class DellinClient implements LoggerAwareInterface
{
	private const ENDPOINTS = [
		'orders' => Orders::class,
		'ordersInfo' => OrdersInfo::class,
		'manageOrders' => ManageOrders::class,
		'calculations' => Calculations::class,
		'authorization' => Authorization::class,
		'services' => Services::class,
		'book' => Book::class,
		'marking' => Marking::class
	];
	public static string $appkey;
	/** @var ApiClient */
	private ApiClient $client;

	public function __construct(string $appkey, ClientInterface $httpClient)
	{
		$this->client = new ApiClient($httpClient, new NullLogger());
		static::$appkey = $appkey;
	}

	public function __get(string $property)
	{
		if (isset(self::ENDPOINTS[$property])) {
			$class = self::ENDPOINTS[$property];

			return new $class($this->client);
		}

		throw new UnknownEndpoint($property);
	}


	public function setLogger(LoggerInterface $logger): void
	{
		$this->client->setLogger($logger);
	}
}
