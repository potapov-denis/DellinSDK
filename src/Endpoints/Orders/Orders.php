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

namespace Yooogi\DellinSDK\Endpoints\Orders;

use Yooogi\DellinSDK\Endpoints\Orders\Entities\Order;
use Yooogi\DellinSDK\Endpoints\Orders\Exceptions\MultiOrderException;
use Yooogi\DellinSDK\Endpoints\Orders\Exceptions\OrderException;
use Yooogi\DellinSDK\Endpoints\Orders\Requests\MultiOrderRequest;
use Yooogi\DellinSDK\Endpoints\Orders\Requests\OrderRequest;
use Yooogi\DellinSDK\Endpoints\Orders\Responses\MultiOrderResponse;
use Yooogi\DellinSDK\Exceptions\BadRequest;
use Yooogi\DellinSDK\Http\ApiClient;

final class Orders
{
	/** @var ApiClient */
	private $client;

	public function __construct(ApiClient $client)
	{
		$this->client = $client;
	}

	/**
	 * Создание заказа на перевозку сборных грузов
	 *
	 * @see https://dev.dellin.ru/api/ordering/ltl-request/
	 *
	 * @param OrderRequest $request
	 *
	 * @throws OrderException
	 *
	 * @return Order Созданный заказ
	 */
	public function create(OrderRequest $request): Order
	{
		try {
			return $this->client->post('/v2/request.json', $request, Order::class);
		} catch (BadRequest $e) {
			throw new OrderException($e);
		}
	}

	/**
	 * Создание мультизаявки
	 *
	 * Настоящий сервис позволяет объединять заказы на доставку с одинаковым адресом отправки в одну мультизаявку для мультиотправки.
	 *
	 * @see https://dev.dellin.ru/api/ordering/multi-request/
	 *
	 * @param MultiOrderRequest $request
	 *
	 * @throws MultiOrderException
	 *
	 * @return MultiOrderResponse
	 */
	public function createMultiOrder(MultiOrderRequest $request): MultiOrderResponse
	{
		try {
			return $this->client->post('/v1/customers/multi_request.json', $request, MultiOrderResponse::class);
		} catch (BadRequest $e) {
			throw new MultiOrderException($e);
		}
	}
}
