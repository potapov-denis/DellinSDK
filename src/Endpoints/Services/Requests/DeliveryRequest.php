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

use Yooogi\DellinSDK\Core\Arrayable;
use Yooogi\DellinSDK\Core\Traits\DataAware;
use Yooogi\DellinSDK\Core\Traits\Login;
use Yooogi\DellinSDK\Entities\DerivalArrival;

abstract class DeliveryRequest implements Arrayable
{
	use DataAware, Login;

	private string $docID;
	private DerivalArrival $arrival;

	/**
	 * Запрос списка возможных дат доставки при оформлении заявки на доставку
	 * Запрос интервала передачи груза на адресе получателя
	 *
	 * @param string $docID
	 * @param DerivalArrival $arrival
	 */
	public function __construct(string $docID, DerivalArrival $arrival)
	{
		$this->setDocID($docID);
		$this->setArrival($arrival);
	}

	/**
	 * Запрос списка возможных дат доставки при оформлении заявки на доставку
	 * Запрос интервала передачи груза на адресе получателя
	 *
	 * @param string $docID
	 * @param DerivalArrival $arrival
	 *
	 * @see https://dev.dellin.ru/api/catalogs/delivery-dates/
	 * @see https://dev.dellin.ru/api/catalogs/time-interva/#_header16
	 *
	 */
	public static function create(string $docID, DerivalArrival $arrival): static
	{
		return new static(...\func_get_args());
	}

	/**
	 * Номер заказа, накладной или заявки на доставку до терминала, оформленной при помощи метода 'Перевозка сборных грузов',
	 * на основании которой планируется дозаказать доставку до адреса
	 * (см. метод 'Дополнение заказа доставкой до адреса получателя')
	 *
	 * @return string
	 */
	public function getDocID(): string
	{
		return $this->docID;
	}

	/**
	 * Номер заказа, накладной или заявки на доставку до терминала, оформленной при помощи метода 'Перевозка сборных грузов',
	 * на основании которой планируется дозаказать доставку до адреса
	 * (см. метод 'Дополнение заказа доставкой до адреса получателя')
	 *
	 * @param string $docID
	 */
	public function setDocID(string $docID): void
	{
		$this->docID = $docID;
	}

	/**
	 * Информация о доставке до адреса получателя. Допускается передача пустого объекта
	 *
	 * @return DerivalArrival
	 */
	public function getArrival(): DerivalArrival
	{
		return $this->arrival;
	}

	/**
	 * Информация о доставке до адреса получателя. Допускается передача пустого объекта
	 *
	 * @param DerivalArrival $arrival
	 */
	public function setArrival(DerivalArrival $arrival): void
	{
		$this->arrival = $arrival;
	}


	public function toArray(): array
	{
		$this->data['delivery']['arrival'] = $this->arrival->toArray();
		$this->data['docID'] = $this->docID;
		return $this->data;
	}
}
