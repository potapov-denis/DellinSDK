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

use Yooogi\DellinSDK\Core\Arrayable;
use Yooogi\DellinSDK\Core\Traits\DataAware;

/**
 * Перечень услуг по накладной
 *
 * @see https://dev.dellin.ru/api/orders/search/#_header17
 */
class Services implements Arrayable
{
	use DataAware;

	private string $name;
	private string $serviceUid;
	private \DateTimeImmutable $createdAt;
	private int $quantity;
	private float $sum;
	private float $totalSum;
	private float $vat;
	private string $vatRate;
	private float $discountSum;

	/**
	 * Наименование услуги
	 *
	 * @return string
	 */
	public function getName(): string
	{
		return $this->get('name');
	}

	/**
	 * UID услуги
	 *
	 * @return string
	 */
	public function getServiceUid(): string
	{
		return $this->get('serviceUid');
	}

	/**
	 * Дата создания
	 *
	 * @return \DateTimeImmutable
	 */
	public function getCreatedAt(): \DateTimeImmutable
	{
		return \DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $this->get('createdAt'));
	}

	/**
	 * Количество
	 *
	 * @return int
	 */
	public function getQuantity(): int
	{
		return $this->get('quantity');
	}

	/**
	 * Сумма
	 *
	 * @return float
	 */
	public function getSum(): float
	{
		return $this->get('sum');
	}

	/**
	 * Сумма итого
	 *
	 * @return float
	 */
	public function getTotalSum(): float
	{
		return $this->get('totalSum');
	}

	/**
	 * НДС
	 *
	 * @return float
	 */
	public function getVat(): float
	{
		return $this->get('vat');
	}

	/**
	 * Ставка НДС, если НДС не применяется, то выводится значение 'БЕЗ НДС'
	 *
	 * @return string
	 */
	public function getVatRate(): string
	{
		return $this->get('vatRate');
	}

	/**
	 * Сумма скидки
	 *
	 * @return float
	 */
	public function getDiscountSum(): float
	{
		return $this->get('discountSum');
	}


	public function toArray(): array
	{
		return $this->data;
	}
}