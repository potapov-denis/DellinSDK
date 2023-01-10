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
use Yooogi\DellinSDK\Entities\Member;
use Yooogi\DellinSDK\Entities\OrderId;

/**
 * Запрос на изменение адреса или времени отправки
 *
 * @see https://dev.dellin.ru/api/order/change-pickup/#_header4
 */
final class ChangePickUpRequest extends OrderId
{

	private DerivalArrival $derival;
	private Member $member;

	/**
	 * Запрос на изменение адреса и времени отправки
	 *
	 * @param string $orderID Номер заказа, в который необходимо внести изменения
	 * @param DerivalArrival $derival ;
	 * @param Member $member
	 *
	 */
	public function __construct(string $orderID, DerivalArrival $derival, Member $member)
	{
		parent::__construct($orderID);
		$this->setDerival($derival);
		$this->setMember($member);
	}

	/**
	 * Запрос на изменение адреса и времени отправки
	 *
	 * @param string $orderID Номер заказа, в который необходимо внести изменения
	 * @param DerivalArrival $derival ;
	 * @param Member $member
	 *
	 */
	public static function create(string $orderID, DerivalArrival $derival, Member $member): ChangePickUpRequest
	{
		return new ChangePickUpRequest(...func_get_args());
	}

	/**
	 * Информация о месте отправления
	 *
	 * @return DerivalArrival
	 */
	public function getDerival(): DerivalArrival
	{
		return $this->derival;
	}

	/**
	 * Информация о месте отправления
	 *
	 * @param DerivalArrival $derival
	 */
	public function setDerival(DerivalArrival $derival): ChangePickUpRequest
	{
		$this->derival = $derival;
		return $this;
	}

	/**
	 * Контактная информация отправителя
	 *
	 * @return Member
	 */
	public function getMember(): Member
	{
		return $this->member;
	}

	/**
	 * Контактная информация отправителя
	 *
	 * @param Member $member
	 */
	public function setMember(Member $member): ChangePickUpRequest
	{
		$this->member = $member;
		return $this;
	}


	public function toArray(): array
	{
		$this->member->setAuth($this->getAuth());
		$this->data['orderID'] = $this->orderID;
		$this->data = array_merge($this->data, $this->member->toArray(), $this->derival->toArray());
		return $this->data;
	}
}