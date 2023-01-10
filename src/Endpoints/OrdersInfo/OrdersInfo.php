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

namespace Yooogi\DellinSDK\Endpoints\OrdersInfo;


use Yooogi\DellinSDK\Core\ArrayOf;
use Yooogi\DellinSDK\Endpoints\OrdersInfo\Exceptions\OrderHistoryException;
use Yooogi\DellinSDK\Endpoints\OrdersInfo\Exceptions\OrderPrintDeliveryException;
use Yooogi\DellinSDK\Endpoints\OrdersInfo\Exceptions\OrderPrintDocumentsException;
use Yooogi\DellinSDK\Endpoints\OrdersInfo\Exceptions\OrderPrintPickUpException;
use Yooogi\DellinSDK\Endpoints\OrdersInfo\Exceptions\OrderSearchException;
use Yooogi\DellinSDK\Endpoints\OrdersInfo\Exceptions\OrdersLogException;
use Yooogi\DellinSDK\Endpoints\OrdersInfo\Requests\OrderHistoryRequest;
use Yooogi\DellinSDK\Endpoints\OrdersInfo\Requests\OrderPrintDocumentsRequest;
use Yooogi\DellinSDK\Endpoints\OrdersInfo\Requests\OrderPrintRequest;
use Yooogi\DellinSDK\Endpoints\OrdersInfo\Requests\OrderSearchRequest;
use Yooogi\DellinSDK\Endpoints\OrdersInfo\Requests\OrdersLogRequest;
use Yooogi\DellinSDK\Endpoints\OrdersInfo\Responses\OrderHistoryResponse;
use Yooogi\DellinSDK\Endpoints\OrdersInfo\Responses\OrderPrintDocumentsResponse;
use Yooogi\DellinSDK\Endpoints\OrdersInfo\Responses\OrderPrintResponse;
use Yooogi\DellinSDK\Endpoints\OrdersInfo\Responses\OrderSearchResponse;
use Yooogi\DellinSDK\Endpoints\OrdersInfo\Responses\OrdersLogResponse;
use Yooogi\DellinSDK\Exceptions\BadRequest;
use Yooogi\DellinSDK\Http\ApiClient;

final class OrdersInfo
{
	/** @var ApiClient */
	private $client;

	public function __construct(ApiClient $client)
	{
		$this->client = $client;
	}

	/**
	 * Журнал заказов
	 *
	 * Сервис позволяет получать актуальную информацию о заказах, используя номер заказа компании 'Деловые Линии',
	 * номер накладной или заявки, внутренний номер заказа интернет-магазина или штрих-код документа.
	 *
	 * @param OrdersLogRequest $request ;
	 *
	 * @return OrdersLogResponse
	 * @throws OrdersLogException
	 *
	 * @see https://dev.dellin.ru/api/orders/search/
	 */
	public function getLog(OrdersLogRequest $request): OrdersLogResponse
	{
		try {
			return $this->client->post('/v3/orders.json', $request, OrdersLogResponse::class);
		} catch (BadRequest $e) {
			throw new OrdersLogException($e);
		}
	}

	/**
	 * Печатные формы заявки на забор
	 *
	 * @param OrderPrintRequest $request ;
	 *
	 * @return OrderPrintResponse
	 * @throws OrderPrintPickUpException
	 *
	 * @see https://dev.dellin.ru/api/orders/print/#_header10
	 */
	public function printPickUp(OrderPrintRequest $request): OrderPrintResponse
	{
		try {
			return $this->client->post('/v1/customers/request/pdf.json', $request, OrderPrintResponse::class);
		} catch (BadRequest $e) {
			throw new OrderPrintPickUpException($e);
		}
	}

	/**
	 * Печатные формы заявки на отвоз
	 *
	 * @param OrderPrintRequest $request ;
	 *
	 * @return OrderPrintResponse
	 * @throws OrderPrintDeliveryException
	 *
	 * @see https://dev.dellin.ru/api/orders/print/#_header10
	 */
	public function printDelivery(OrderPrintRequest $request): OrderPrintResponse
	{
		try {
			return $this->client->post('/v1/customers/request_sf/pdf.json', $request, OrderPrintResponse::class);
		} catch (BadRequest $e) {
			throw new OrderPrintPickUpException($e);
		}
	}

	/**
	 * Печатные формы заявки на отвоз
	 *
	 * @param OrderPrintDocumentsRequest $request ;
	 *
	 * @return OrderPrintDocumentsResponse[]|null
	 * @throws OrderPrintDocumentsException
	 *
	 * @see https://dev.dellin.ru/api/orders/print/#_header10
	 */
	public function printDocuments(OrderPrintDocumentsRequest $request): ?array
	{
		try {
			return $this->client->post('/v1/printable.json', $request, new ArrayOf (OrderPrintDocumentsResponse::class));
		} catch (BadRequest $e) {
			throw new OrderPrintDocumentsException($e);
		}
	}

	/**
	 * История заказа
	 *
	 * Сервис позволяет получать историю изменений заказов, а также отслеживать статус заявки на внесение изменений.
	 * Сервис доступен только авторизованным пользователям.
	 *
	 * @param OrderHistoryRequest $request ;
	 *
	 * @return OrderHistoryResponse[]|null
	 * @throws OrderHistoryException
	 *
	 * @see https://dev.dellin.ru/api/orders/history/
	 */
	public function getHistory(OrderHistoryRequest $request): ?array
	{
		try {
			return $this->client->post('/v3/orders/history.json', $request, new ArrayOf (OrderHistoryResponse::class));
		} catch (BadRequest $e) {
			throw new OrderHistoryException($e);
		}
	}

	/**
	 * Поиск заказа по параметрам перевозки
	 *
	 * Сервис позволяет найти заказ, номер которого не известен. Для поиска используются следующие данные:
	 * ИНН (для юридических лиц), тип и номер документа (для физических лиц), маршрут перевозки и дата отправки заказа.
	 * Использование необязательных параметров позволяет выделить заказ из множества.
	 *
	 * Если номер заказа известен, то найти заказ можно при помощи метода 'Журнал заказов'.
	 *
	 * @param OrderSearchRequest $request ;
	 *
	 * @return OrderHistoryResponse[]|null
	 * @throws OrderHistoryException
	 *
	 * @see https://dev.dellin.ru/api/orders/partial-search/
	 */
	public function search(OrderSearchRequest $request): ?array
	{
		try {
			return $this->client->post('/v2/tracker_advanced.json', $request, OrderSearchResponse::class);
		} catch (BadRequest $e) {
			throw new OrderSearchException($e);
		}
	}

}

