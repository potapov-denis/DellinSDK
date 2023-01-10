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

namespace Yooogi\DellinSDK\Endpoints\OrdersInfo\Entities;

use DateTimeImmutable;
use Yooogi\DellinSDK\Core\Traits\DataAware;

/**
 * Массив блокировок по заказу
 *
 * @see https://dev.dellin.ru/api/orders/search/#_header15
 */
class Locks implements \Yooogi\DellinSDK\Core\Arrayable
{

	use DataAware;

	private ?string $name;
	private ?string $type;
	private ?DateTimeImmutable $setDate;
	private ?DateTimeImmutable $endDate;

	/**
	 * Наименование блокировки
	 *
	 * @return string|null
	 */
	public function getName(): ?string
	{
		return $this->get('name');
	}

	/**
	 * Тип блокировки
	 *
	 * @return string|null
	 */
	public function getType(): ?string
	{
		return $this->get('type');
	}

	/**
	 * Дата установки блокировки
	 *
	 * @return DateTimeImmutable|null
	 */
	public function getSetDate(): ?DateTimeImmutable
	{
		return DateTimeImmutable::createFromFormat('Y-m-d', $this->get('setDate'));
	}

	/**
	 * Дата снятия блокировки
	 *
	 * @return DateTimeImmutable|null
	 */
	public function getEndDate(): ?DateTimeImmutable
	{
		return DateTimeImmutable::createFromFormat('Y-m-d', $this->get('endDate'));
	}


	public function toArray(): array
	{
		return $this->data;
	}
}