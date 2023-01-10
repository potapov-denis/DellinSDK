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

namespace Yooogi\DellinSDK\Endpoints\Services\Requests;

use DateTimeImmutable;
use Yooogi\DellinSDK\Entities\Cargo;
use Yooogi\DellinSDK\Entities\DerivalArrival;
use Yooogi\DellinSDK\Enum\DeliveryType;
use function func_get_args;

/**
 * Запрос сервиса получения возможных дат передачи груза водителю-экспедитору на адресе отправителя или же дат сдачи груза на терминал при оформлении заявки при помощи метода
 * 'Перевозка сборных грузов'.
 *
 * @see https://dev.dellin.ru/api/catalogs/dispatch-dates/
 */
final class DispatchDateRequest extends DispatchRequest
{

	private Cargo $cargo;
	private ?DateTimeImmutable $datetime = null;

	/**
	 * Запрос сервиса получения возможных дат передачи груза водителю-экспедитору на адресе отправителя или же дат сдачи груза на терминал при оформлении заявки при помощи метода
	 * 'Перевозка сборных грузов'.
	 *
	 * @param DeliveryType $deliveryType
	 * @param DerivalArrival $derival
	 * @param Cargo $cargo
	 *
	 * @see https://dev.dellin.ru/api/catalogs/dispatch-dates/
	 */
	public function __construct(DeliveryType $deliveryType, DerivalArrival $derival, Cargo $cargo, ?DateTimeImmutable $datetime = null)
	{
		parent::__construct($deliveryType, $derival);
		$this->setCargo($cargo);
		$this->setDatetime($datetime);

	}

	/**
	 * Запрос сервиса получения возможных дат передачи груза водителю-экспедитору на адресе отправителя или же дат сдачи груза на терминал при оформлении заявки при помощи метода
	 * 'Перевозка сборных грузов'.
	 *
	 * @param DeliveryType $deliveryType
	 * @param DerivalArrival $derival
	 * @param Cargo $cargo
	 *
	 * @see https://dev.dellin.ru/api/catalogs/dispatch-dates/
	 */
	public static function create(DeliveryType $deliveryType, DerivalArrival $derival, Cargo $cargo, ?DateTimeImmutable $datetime = null): DispatchDateRequest
	{
		return new DispatchDateRequest(...func_get_args());
	}

	/**
	 * Информация о грузе
	 *
	 * @return Cargo
	 */
	public function getCargo(): Cargo
	{
		return $this->cargo;
	}

	/**
	 * Информация о грузе
	 *
	 * @param Cargo $cargo
	 */
	public function setCargo(Cargo $cargo): void
	{
		$this->cargo = $cargo;
	}


	/**
	 * @return DateTimeImmutable|null
	 */
	public function getDatetime(): ?DateTimeImmutable
	{
		return $this->datetime;
	}

	/**
	 * @param DateTimeImmutable|null $datetime
	 */
	public function setDatetime(?DateTimeImmutable $datetime): void
	{
		$this->datetime = $datetime;
	}


	public function toArray(): array
	{
		parent::toArray();
		$this->data['cargo'] = $this->cargo->toArray();
		if ($this->datetime) $this->data['datetime'] = $this->datetime->format('Y-m-d H');
		return $this->data;
	}
}
