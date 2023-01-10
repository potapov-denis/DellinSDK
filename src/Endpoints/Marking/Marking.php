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

namespace Yooogi\DellinSDK\Endpoints\Marking;
 

use Yooogi\DellinSDK\Core\ArrayOf;
use Yooogi\DellinSDK\Endpoints\Marking\Exceptions\GetAcDocShippingLabelsException;
use Yooogi\DellinSDK\Endpoints\Marking\Exceptions\GetCargoStatusesException;
use Yooogi\DellinSDK\Endpoints\Marking\Exceptions\GetHandlingMarksCatalogException;
use Yooogi\DellinSDK\Endpoints\Marking\Exceptions\GetHandlingMarksException;
use Yooogi\DellinSDK\Endpoints\Marking\Exceptions\GetPackagingMarksCatalogException;
use Yooogi\DellinSDK\Endpoints\Marking\Exceptions\GetPackagingMarksException;
use Yooogi\DellinSDK\Endpoints\Marking\Exceptions\GetShippingLabelsException;
use Yooogi\DellinSDK\Endpoints\Marking\Exceptions\MakeShippingLabelsException;
use Yooogi\DellinSDK\Endpoints\Marking\Requests\GetAcDocShippingLabelsRequest;
use Yooogi\DellinSDK\Endpoints\Marking\Requests\GetCargoStatusesRequest;
use Yooogi\DellinSDK\Endpoints\Marking\Requests\GetHandlingMarksCatalogRequest;
use Yooogi\DellinSDK\Endpoints\Marking\Requests\GetHandlingMarksRequest;
use Yooogi\DellinSDK\Endpoints\Marking\Requests\GetPackagingMarksCatalogRequest;
use Yooogi\DellinSDK\Endpoints\Marking\Requests\GetPackagingMarksRequest;
use Yooogi\DellinSDK\Endpoints\Marking\Requests\GetShippingLabelsRequest;
use Yooogi\DellinSDK\Endpoints\Marking\Requests\MakeShippingLabelsRequest;
use Yooogi\DellinSDK\Endpoints\Marking\Responses\GetAcDocShippingLabelsResponse;
use Yooogi\DellinSDK\Endpoints\Marking\Responses\GetCargoStatusesResponse;
use Yooogi\DellinSDK\Endpoints\Marking\Responses\GetHandlingMarksCatalogResponse;
use Yooogi\DellinSDK\Endpoints\Marking\Responses\GetHandlingMarksResponse;
use Yooogi\DellinSDK\Endpoints\Marking\Responses\GetPackagingMarksCatalogResponse;
use Yooogi\DellinSDK\Endpoints\Marking\Responses\GetPackagingMarksResponse;
use Yooogi\DellinSDK\Endpoints\Marking\Responses\GetShippingLabelsResponse;
use Yooogi\DellinSDK\Endpoints\Marking\Responses\MakeShippingLabelsResponse;
use Yooogi\DellinSDK\Exceptions\BadRequest;
use Yooogi\DellinSDK\Http\ApiClient;

final class Marking
{
	/** @var ApiClient */
	private $client;

	public function __construct(ApiClient $client)
	{
		$this->client = $client;
	}

	/**
	 * Передача артикулов грузовых мест
	 *
	 * @see https://dev.dellin.ru/api/marking/labels/#_header2
	 *
	 * @param MakeShippingLabelsRequest $request
	 *
	 * @throws MakeShippingLabelsException
	 *
	 * @return MakeShippingLabelsResponse|null
	 */
	public function makeShippingLabels(MakeShippingLabelsRequest $request): ?MakeShippingLabelsResponse
	{
		try {
			return $this->client->post('/v2/request/cargo/shipment_labels.json', $request, MakeShippingLabelsResponse::class);
		} catch (BadRequest $e) {
			throw new MakeShippingLabelsException($e);
		}
	}

	/**
	 * Получение этикеток на груз
	 *
	 * @see https://dev.dellin.ru/api/marking/labels/#_header2
	 *
	 * @param GetShippingLabelsRequest $request
	 *
	 * @throws GetShippingLabelsException
	 *
	 * @return array<int, GetShippingLabelsResponse>|null
	 */
	public function getShippingLabels(GetShippingLabelsRequest $request): ?array
	{
		try {
			return $this->client->post('/v2/request/cargo/shipment_labels/get.json', $request, new ArrayOf(GetShippingLabelsResponse::class));
		} catch (BadRequest $e) {
			throw new GetShippingLabelsException($e);
		}
	}

	/**
	 * Получение этикеток на сопроводительные документы
	 *
	 * @see https://dev.dellin.ru/api/marking/labels/#_header22
	 *
	 * @param GetAcDocShippingLabelsRequest $request
	 *
	 * @throws GetAcDocShippingLabelsException
	 *
	 * @return array<int, GetAcDocShippingLabelsResponse>|null
	 */
	public function getAcDocShippingLabels(GetAcDocShippingLabelsRequest $request): ?array
	{
		try {
			return $this->client->post('/v2/request/cargo/docs_shipment_labels/get.json', $request, new ArrayOf(GetAcDocShippingLabelsResponse::class));
		} catch (BadRequest $e) {
			throw new GetAcDocShippingLabelsException($e);
		}
	}

	/**
	 * Получение статусов грузомест
	 *
	 * @see https://dev.dellin.ru/api/marking/labels/#_header22
	 *
	 * @param GetCargoStatusesRequest $request
	 *
	 * @throws GetCargoStatusesException
	 *
	 * @return array<int, GetCargoStatusesResponse>|null
	 */
	public function getCargoStatuses(GetCargoStatusesRequest $request): ?array
	{
		try {
			return $this->client->post('/v3/orders/cargo/statuses.json', $request, new ArrayOf(GetCargoStatusesResponse::class));
		} catch (BadRequest $e) {
			throw new GetCargoStatusesException($e);
		}
	}

	/**
	 * Получение справочника этикеток с манипуляционными знаками
	 *
	 * @see https://dev.dellin.ru/api/marking/marks/#_header2
	 *
	 * @param GetHandlingMarksCatalogRequest $request
	 *
	 * @throws GetHandlingMarksCatalogException
	 *
	 * @return array<int, GetHandlingMarksCatalogResponse>|null
	 */
	public function getHandlingMarksCatalog(GetHandlingMarksCatalogRequest $request): ?array
	{
		try {
			return $this->client->post('/v1/references/marking/handling_marks.json', $request, new ArrayOf(GetHandlingMarksCatalogResponse::class));
		} catch (BadRequest $e) {
			throw new GetHandlingMarksCatalogException($e);
		}
	}

	/**
	 * Получение этикеток с манипуляционными знаками
	 *
	 * @see https://dev.dellin.ru/api/marking/marks/#_header12
	 *
	 * @param GetHandlingMarksRequest $request
	 *
	 * @throws GetHandlingMarksException
	 *
	 * @return array<int, GetHandlingMarksResponse>|null
	 */
	public function getHandlingMarks(GetHandlingMarksRequest $request): ?array
	{
		try {
			return $this->client->post('/v1/references/marking/handling_marks/get.json', $request, new ArrayOf(GetHandlingMarksResponse::class));
		} catch (BadRequest $e) {
			throw new GetHandlingMarksException($e);
		}
	}

	/**
	 * Получение справочника этикеток типов упаковки
	 *
	 * @see https://dev.dellin.ru/api/marking/packaging/#_header2
	 *
	 * @param GetPackagingMarksCatalogRequest $request
	 *
	 * @throws GetPackagingMarksCatalogException
	 *
	 * @return array<int, GetPackagingMarksCatalogResponse>|null
	 */
	public function getPackagingMarksCatalog(GetPackagingMarksCatalogRequest $request): ?array
	{
		try {
			return $this->client->post('/v1/references/marking/packaging_marks.json', $request, new ArrayOf(GetPackagingMarksCatalogResponse::class));
		} catch (BadRequest $e) {
			throw new GetPackagingMarksCatalogException($e);
		}
	}

	/**
	 * Получение этикеток типов упаковки
	 *
	 * @see https://dev.dellin.ru/api/marking/packaging/#_header13
	 *
	 * @param GetPackagingMarksRequest $request
	 *
	 * @throws GetPackagingMarksException
	 *
	 * @return array<int, GetPackagingMarksResponse>|null
	 */
	public function getPackagingMarks(GetPackagingMarksRequest $request): ?array
	{
		try {
			return $this->client->post('/v1/references/marking/packaging_marks/get.json', $request, new ArrayOf(GetPackagingMarksResponse::class));
		} catch (BadRequest $e) {
			throw new GetPackagingMarksException($e);
		}
	}
}
