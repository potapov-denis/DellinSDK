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

use Yooogi\DellinSDK\Entities\Members;
use Yooogi\DellinSDK\Entities\OrderId;
use function func_get_args;

/**
 * Запрос на изменение контактных данных по отправлению
 *
 * @see https://dev.dellin.ru/api/order/change-contacts/#_header3
 */
final class ChangeContactsRequest extends OrderId
{

	/**
	 * Изменяемая контактная информация участников перевозки
	 *
	 * @var Members
	 */
	private Members $members;

	/**
	 * Создать запрос на изменение контактных данных по отправлению
	 *
	 * @param string $orderID Номер заказа, в который необходимо внести изменения
	 * @param Members $members Изменяемая контактная информация участников перевозки.
	 */
	public function __construct(string $orderID, Members $members)
	{
		parent::__construct($orderID);
		$this->setMembers($members);
	}

	/**
	 * Создать запрос на изменение контактных данных по отправлению
	 *
	 * @param string $orderID Номер заказа, в который необходимо внести изменения
	 * @param Members $members Изменяемая контактная информация участников перевозки.
	 *
	 * @return static
	 */
	public static function create(string $orderID, Members $members): static
	{
		return new self(...func_get_args());
	}

	/**
	 * Изменяемая контактная информация участников перевозки.
	 * Могут быть переданы новые контактные данные или изменена информация,
	 * уже сохраненная в адресной книге учетной записи личного кабинета
	 *
	 * @return Members
	 */
	public function getMembers(): Members
	{
		return $this->members;
	}

	/**
	 * Изменяемая контактная информация участников перевозки.
	 * Могут быть переданы новые контактные данные или изменена информация,
	 * уже сохраненная в адресной книге учетной записи личного кабинета
	 *
	 * @param Members $members
	 */
	public function setMembers(Members $members): void
	{
		$this->members = $members;
	}


	/**
	 * @return array
	 */
	public function toArray(): array
	{
		$this->members->setAuth($this->getAuth());
		$this->data['orderID'] = $this->orderID;
		$this->data['members'] = $this->members->toArray();
		return $this->data;
	}
}