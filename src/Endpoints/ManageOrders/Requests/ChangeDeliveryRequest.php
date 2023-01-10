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

declare (strict_types=1);

namespace Yooogi\DellinSDK\Endpoints\ManageOrders\Requests;

use Yooogi\DellinSDK\Entities\DerivalArrival;
use Yooogi\DellinSDK\Entities\Members;
use Yooogi\DellinSDK\Entities\OrderId;
use Yooogi\DellinSDK\Enum\RequesterType;

/**
 * Запрос на изменение адреса и времени доставки
 *
 * @see https://dev.dellin.ru/api/order/change-delivery/#_header4
 */
final class ChangeDeliveryRequest extends OrderId
{

	/**
	 * Параметры доставки
	 *
	 * @var DerivalArrival
	 */
	private DerivalArrival $arrival;
	/**
	 * Участники перевозки
	 * @var Members
	 */
	private Members $members;

	/**
	 * Сторона, берущая на себя расходы на платное хранение.
	 * @var RequesterType|null
	 */
	private ?RequesterType $storePayer = null;

	/**
	 * Запрос на изменение адреса и времени доставки
	 *
	 * @param string $orderID Номер заказа, в который необходимо внести изменения
	 * @param DerivalArrival $arrival Доставка до адреса
	 * @param Members $members Участники перевозки
	 * @param RequesterType|null $storePayer Сторона, берущая на себя расходы на платное хранение.
	 */
	public function __construct(string $orderID, DerivalArrival $arrival, Members $members, ?RequesterType $storePayer = null)
	{
		parent::__construct($orderID);
		$this->setArrival($arrival);
		$this->setMembers($members);
		$this->setStorePayer($storePayer);
	}

	/**
	 * Запрос на изменение адреса и времени доставки
	 *
	 * @param string $orderID Номер заказа, в который необходимо внести изменения
	 * @param DerivalArrival $arrival Доставка до адреса
	 * @param Members $members Участники перевозки
	 * @param RequesterType|null $storePayer Сторона, берущая на себя расходы на платное хранение.
	 *
	 * @return ChangePickUpRequest
	 */
	public static function create(string $orderID, DerivalArrival $arrival, Members $members, ?RequesterType $storePayer = null): ChangeDeliveryRequest
	{
		return new ChangeDeliveryRequest(...func_get_args());
	}

	/**
	 * Информация о месте доставки
	 *
	 * @return DerivalArrival
	 */
	public function getArrival(): DerivalArrival
	{
		return $this->arrival;
	}

	/**
	 * Информация о месте доставки
	 *
	 * @param DerivalArrival $arrival
	 *
	 * @return ChangeDeliveryRequest
	 */
	public function setArrival(DerivalArrival $arrival): ChangeDeliveryRequest
	{
		$this->arrival = $arrival;
		return $this;
	}

	/**
	 * Участники перевозки
	 *
	 * @return Members
	 */
	public function getMembers(): Members
	{
		return $this->members;
	}

	/**
	 * Участники перевозки
	 *
	 * @param Members $members
	 *
	 * @return ChangeDeliveryRequest
	 */
	public function setMembers(Members $members): ChangeDeliveryRequest
	{
		$this->members = $members;
		return $this;
	}

	/**
	 * Сторона, берущая на себя расходы на платное хранение.
	 *
	 * @return RequesterType|null
	 */
	public function getStorePayer(): ?RequesterType
	{
		return $this->storePayer;
	}

	/**
	 * Сторона, берущая на себя расходы на платное хранение.
	 *
	 * @param RequesterType|null $storePayer
	 */
	public function setStorePayer(?RequesterType $storePayer): void
	{
		$this->storePayer = $storePayer;
	}


	public function toArray(): array
	{
		$this->members->setAuth($this->getAuth());
		$this->data['orderID'] = $this->orderID;
		$this->data['delivery']['arrival'] = $this->arrival->toArray();
		if ($this->storePayer) $this->data['storePayer'] = $this->storePayer->value;
		$this->data['members'] = $this->members->toArray();

		return $this->data;
	}
}