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

namespace Yooogi\DellinSDK\Endpoints\Services;

use Yooogi\DellinSDK\Endpoints\Services\Exceptions\{AvailablePackagesException, ConditionsException, DeliveryDatesException, DispatchDatesException, SenderCounteragentException,
	TerminalDatesException, TimeIntervalException};
use Yooogi\DellinSDK\Endpoints\Services\Requests\{AvailablePackagesRequest, ConditionsRequest, DeliveryRequest, DeliveryTimeRequest, DispatchRequest, DispatchTimeRequest,
	SenderCounteragentsRequest, TerminalDatesRequest};
use Yooogi\DellinSDK\Endpoints\Services\Responses\{AvailablePackagesResponse, ConditionsResponse, DatesResponse, SenderCounteragentsResponse, TimeIntervalResponse};
use Yooogi\DellinSDK\Exceptions\BadRequest;
use Yooogi\DellinSDK\Http\ApiClient;

final class Services
{
	/** @var ApiClient */
	private $client;

	public function __construct(ApiClient $client)
	{
		$this->client = $client;
	}

	/**
	 * Одна учетная запись Личного кабинета (далее - ЛК) может быть связана с нескольким контрагентами, то есть посредством одной учётной записи можно от имени разных
	 * контрагентов оформлять заказы, получать информацию о взаиморасчетах и т. д.
	 *
	 * Этот метод позволяет:
	 *
	 * получить основную информацию о контрагентах, связанных с одной учетной записи в ЛК;
	 * получить полную информацию о контрагентах, связанных с одной учетной записи в ЛК;
	 * получить информацию о взаиморасчётах по каждому контрагенту;
	 * сменить текущего контрагента для осуществления разных операций в ЛК.
	 *
	 * @param SenderCounteragentsRequest $request
	 *
	 * @return SenderCounteragentsResponse[]|null
	 *
	 * @throws SenderCounteragentException
	 * @see https://dev.dellin.ru/api/auth/counteragents/
	 *
	 */
	public function getCounteragents(SenderCounteragentsRequest $request): ?SenderCounteragentsResponse
	{
		try {
			return $this->client->post('/v2/counteragents.json', $request, SenderCounteragentsResponse::class);
		} catch (BadRequest $e) {
			throw new SenderCounteragentException($e);
		}
	}

	/**
	 * Метод позволяет получить информацию об ограничениях и возможных значениях параметров в зависимости от условий заказа.
	 *
	 *
	 * @param ConditionsRequest $request
	 *
	 * @return ConditionsResponse|null
	 *
	 * @throws ConditionsException
	 *
	 * @see https://dev.dellin.ru/api/catalogs/request-conditions/
	 */
	public function getConditions(ConditionsRequest $request): ?ConditionsResponse
	{
		try {
			return $this->client->post('/v1/public/request_conditions.json', $request, ConditionsResponse::class);
		} catch (BadRequest $e) {
			throw new ConditionsException($e);
		}
	}

	/**
	 * Сервис позволяет получить список возможных дат передачи груза водителю-экспедитору на адресе отправителя
	 * или же дат сдачи груза на терминал при оформлении заявки при помощи метода 'Перевозка сборных грузов'.
	 * Сервис доступен как авторизованным, так и неавторизованным пользователям.
	 *
	 *
	 * @param DispatchRequest $request
	 *
	 * @return DatesResponse|null
	 * @throws DispatchDatesException
	 *
	 * @see https://dev.dellin.ru/api/catalogs/dispatch-dates/
	 *
	 */
	public function getDispatchDates(DispatchRequest $request): ?DatesResponse
	{
		try {
			return $this->client->post('/v2/request/address/dates.json', $request, DatesResponse::class);
		} catch (BadRequest $e) {
			throw new DispatchDatesException($e);
		}
	}

	/**
	 * Сервис позволяет получить список возможных дат доставки при оформлении заявки на доставку от терминала до адреса получателя
	 * (см. метод 'Дополнение заказа доставкой до адреса получателя').
	 * Сервис доступен только авторизованным пользователям.
	 *
	 *
	 * @param DeliveryRequest $request
	 *
	 * @return DatesResponse|null
	 * @throws DeliveryDatesException
	 *
	 * @see https://dev.dellin.ru/api/catalogs/delivery-dates/
	 *
	 */
	public function getDeliveryDates(DeliveryRequest $request): ?DatesResponse
	{
		try {
			return $this->client->post('/v2/request_delivery/address/dates.json', $request, DatesResponse::class);
		} catch (BadRequest $e) {
			throw new DeliveryDatesException($e);
		}
	}

	/**
	 * Сервис позволяет получить информацию о доступных интервалах приезда водителя-экспедитора при передаче груза
	 * на адресе отправителя.
	 *
	 * Проверка интервалов передачи груза при отправке доступна неавторизованным пользователям.
	 *
	 *
	 * @param DispatchTimeRequest $request
	 *
	 * @return TimeIntervalResponse|null
	 * @throws DeliveryDatesException
	 *
	 * @see https://dev.dellin.ru/api/catalogs/time-interva/#_header2
	 *
	 */
	public function getDispatchTimeInterval(DispatchTimeRequest $request): ?TimeIntervalResponse
	{
		try {
			return $this->client->post('/v2/request/address/time_interval.json', $request, TimeIntervalResponse::class);
		} catch (BadRequest $e) {
			throw new TimeIntervalException($e);
		}
	}


	/**
	 * Сервис позволяет получить информацию об интервалах доставки груза до адреса получателя.
	 * Проверки интервалов доставки необходима авторизация.
	 *
	 * @param DeliveryTimeRequest $request
	 *
	 * @return TimeIntervalResponse|null
	 * @throws TimeIntervalException
	 *
	 * @see https://dev.dellin.ru/api/catalogs/time-interva/#_header16
	 *
	 */
	public function getDeliveryTimeInterval(DeliveryTimeRequest $request): ?TimeIntervalResponse
	{
		try {
			return $this->client->post('/v2/request_delivery/address/time_interval.json', $request, TimeIntervalResponse::class);
		} catch (BadRequest $e) {
			throw new TimeIntervalException($e);
		}
	}

	/**
	 * Сервис возвращает список доступных упаковок по переданным параметрам.
	 *
	 * @param AvailablePackagesRequest $request
	 *
	 * @return AvailablePackagesResponse|null
	 * @throws AvailablePackagesException
	 *
	 * @see https://dev.dellin.ru/api/catalogs/available-packages/
	 *
	 */
	public function getAvailablePackages(AvailablePackagesRequest $request): ?AvailablePackagesResponse
	{
		try {
			return $this->client->post('/v1/public/packages_available.json', $request, AvailablePackagesResponse::class);
		} catch (BadRequest $e) {
			throw new AvailablePackagesException($e);
		}
	}


	/**
	 * Сервис позволяет получить информацию о доступных датах отгрузки на терминал
	 *
	 *
	 * @param TerminalDatesRequest $request
	 *
	 * @return DatesResponse|null
	 * @throws TerminalDatesException
	 */
	public function getTerminalDates(TerminalDatesRequest $request): ?DatesResponse
	{
		try {
			return $this->client->post('/v2/request/terminal/dates.json', $request, DatesResponse::class);
		} catch (BadRequest $e) {
			throw new TerminalDatesException($e);
		}
	}

}
