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

namespace Yooogi\DellinSDK\Endpoints\Calculations;

use Yooogi\DellinSDK\Core\ArrayOf;
use Yooogi\DellinSDK\Endpoints\Calculations\Exceptions\CalculationException;
use Yooogi\DellinSDK\Endpoints\Calculations\Exceptions\DeliveryException;
use Yooogi\DellinSDK\Endpoints\Calculations\Requests\CalculationRequest;
use Yooogi\DellinSDK\Endpoints\Calculations\Requests\DeliveryRequest;
use Yooogi\DellinSDK\Endpoints\Calculations\Responses\CalculationResponse;
use Yooogi\DellinSDK\Endpoints\Calculations\Responses\DeliveryResponse;
use Yooogi\DellinSDK\Exceptions\BadRequest;
use Yooogi\DellinSDK\Http\ApiClient;

final class Calculations
{
	/** @var ApiClient */
	private $client;

	public function __construct(ApiClient $client)
	{
		$this->client = $client;
	}


	/**
	 * Сервис позволяет *асинхронно* получить подробную информацию о стоимости и сроках интересующего способа перевозки.
	 *
	 * @param CalculationRequest[] $requests
	 *
	 * @return CalculationResponse[]
	 *
	 * @see https://dev.dellin.ru/api/calculation/calculator/
	 */
	public function asyncCalculate(array $requests): iterable
	{
		try {
			return $this->client->post('/v2/calculator.json', $requests, new ArrayOf(CalculationResponse::class), true);
		} catch (BadRequest $e) {
			throw new CalculationException($e);
		}
	}

	/**
	 * Сервис позволяет получить подробную информацию о стоимости и сроках интересующего способа перевозки.
	 *
	 * @param CalculationRequest $request
	 *
	 * @return CalculationResponse
	 *
	 * @see https://dev.dellin.ru/api/calculation/calculator/
	 */
	public function calculate(CalculationRequest $request): CalculationResponse
	{
		try {
			return $this->client->post('/v2/calculator.json', $request, CalculationResponse::class);
		} catch (BadRequest $e) {
			throw new CalculationException($e);
		}

	}

	/**
	 * Сервис позволяет рассчитать стоимость услуги 'Доставка до адреса' для активной перевозки.
	 *
	 * @param DeliveryRequest $request
	 *
	 * @return DeliveryResponse
	 * @throws DeliveryException
	 *
	 * @see https://dev.dellin.ru/api/calculation/delivery/
	 */
	public function delivery(DeliveryRequest $request): DeliveryResponse
	{
		try {
			return $this->client->post('/v1/public/calculator_sf.json', $request, DeliveryResponse::class);
		} catch (BadRequest $e) {
			throw new DeliveryException($e);
		}

	}

}
