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

use Yooogi\DellinSDK\Entities\Member;
use Yooogi\DellinSDK\Enum\RequesterType;

/**
 * Запрос метода отмены доставки до адреса получателя
 *
 * @see https://dev.dellin.ru/api/order/cancel/#_header13
 */
final class CancelDeliveryRequest extends CancelRequest
{

	private RequesterType $requester;

	/**
	 * Запрос методы отмены доставки до адреса получателя
	 *
	 * @param string $orderID
	 * @param Member $member
	 *
	 * @see https://dev.dellin.ru/api/order/cancel/#_header7
	 */
	public function __construct(string $orderID, Member $member, RequesterType $requester)
	{
		parent::__construct($orderID, $member);
		$this->setRequester($requester);
	}

	/**
	 * Запрос методы отмены доставки до адреса получателя
	 *
	 * @param string $orderID
	 * @param Member $member
	 *
	 * @return CancelDeliveryRequest
	 *
	 * @see https://dev.dellin.ru/api/order/cancel/#_header7
	 */
	public static function create(string $orderID, Member $member, RequesterType $requester): CancelDeliveryRequest
	{
		return new CancelDeliveryRequest(...func_get_args());
	}

	/**
	 * Роль пользователя, подающего запрос на отмену доставки.
	 *
	 * Доступные значения:
	 *
	 * 'sender' - отправитель;
	 * 'receiver' - получатель;
	 * 'customer' - заказчик
	 *
	 * @return RequesterType
	 */
	public function getRequester(): RequesterType
	{
		return $this->requester;
	}

	/**
	 * Роль пользователя, подающего запрос на отмену доставки.
	 *
	 * Доступные значения:
	 *
	 * 'sender' - отправитель;
	 * 'receiver' - получатель;
	 * 'customer' - заказчик
	 *
	 *
	 * @param RequesterType $requester
	 */
	public function setRequester(RequesterType $requester): void
	{
		$this->requester = $requester;
	}

	public function toArray(): array
	{
		$this->data = parent::toArray();
		$this->data['requester'] = $this->requester->value;
		return $this->data;
	}

}