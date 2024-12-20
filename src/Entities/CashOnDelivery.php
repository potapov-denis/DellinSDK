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

namespace Yooogi\DellinSDK\Entities;

use DateTime;
use DateTimeImmutable;
use Yooogi\DellinSDK\Core\Arrayable;
use Yooogi\DellinSDK\Core\Traits\DataAware;
use Yooogi\DellinSDK\Enum\CashOnDeliveryPaymentType;
use function func_get_args;


final class CashOnDelivery implements Arrayable
{
	use DataAware;

	private bool $cashOnDelivery = false;
	private ?string $orderNumber;
	private ?DateTimeImmutable $orderDate;
	private ?CashOnDeliveryPaymentType $cashOnDeliveryPaymentType;
	/**
	 * @var Product[]
	 */
	private ?array $products;

	/**
	 * @param bool $cashOnDelivery Наложенный платеж.
	 * @param ?string $orderNumber Внутренний номер заказа клиента (например, номер заказа интернет-магазина).
	 * @param ?DateTime $orderDate Дата заказа
	 * @param ?CashOnDeliveryPaymentType $cashOnDeliveryPaymentType Заявленный вид оплаты.
	 * @param Product[] $products ;
	 */
	public function __construct(
		bool                       $cashOnDelivery = false,
		?string                    $orderNumber = null,
		?DateTime                  $orderDate = null,
		?CashOnDeliveryPaymentType $cashOnDeliveryPaymentType = null,
		?array                     $products = null)
	{
		$this->setCashOnDelivery($cashOnDelivery);
		$this->setOrderNumber($orderNumber);
		$this->setOrderDate($orderDate);
		$this->setCashOnDeliveryPaymentType($cashOnDeliveryPaymentType);
		$this->setProducts($products);
	}

	/**
	 * @param bool $cashOnDelivery Наложенный платеж.
	 * @param ?string $orderNumber Внутренний номер заказа клиента (например, номер заказа интернет-магазина).
	 * @param ?DateTime $orderDate Дата заказа
	 * @param ?CashOnDeliveryPaymentType $cashOnDeliveryPaymentType Заявленный вид оплаты.
	 * @param Product[] $products ;
	 */
	public static function create(bool                       $cashOnDelivery = false,
	                              ?string                    $orderNumber = null,
	                              ?DateTime                  $orderDate = null,
	                              ?CashOnDeliveryPaymentType $cashOnDeliveryPaymentType = null,
	                              ?array                     $products = null): self
	{
		return new self(...func_get_args());
	}

	/**
	 * @return bool
	 */
	public function isCashOnDelivery(): bool
	{
		return $this->cashOnDelivery;
	}

	/**
	 * @param bool $cashOnDelivery
	 */
	public function setCashOnDelivery(bool $cashOnDelivery): CashOnDelivery
	{
		$this->cashOnDelivery = $cashOnDelivery;
		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getOrderNumber(): ?string
	{
		return $this->orderNumber;
	}

	/**
	 * @param string|null $orderNumber
	 */
	public function setOrderNumber(?string $orderNumber): CashOnDelivery
	{
		$this->orderNumber = $orderNumber;
		return $this;
	}

	/**
	 * @return DateTimeImmutable|null
	 */
	public function getOrderDate(): ?DateTimeImmutable
	{
		return $this->orderDate;
	}

	/**
	 * @param DateTimeImmutable|null $orderDate
	 */
	public function setOrderDate(?DateTimeImmutable $orderDate): CashOnDelivery
	{
		$this->orderDate = $orderDate;
		return $this;
	}

	/**
	 * @return CashOnDeliveryPaymentType|null
	 */
	public function getCashOnDeliveryPaymentType(): ?CashOnDeliveryPaymentType
	{
		return $this->cashOnDeliveryPaymentType;
	}

	/**
	 * @param CashOnDeliveryPaymentType|null $cashOnDeliveryPaymentType
	 */
	public function setCashOnDeliveryPaymentType(?CashOnDeliveryPaymentType $cashOnDeliveryPaymentType): CashOnDelivery
	{
		$this->cashOnDeliveryPaymentType = $cashOnDeliveryPaymentType;
		return $this;
	}

	/**
	 * @return Product[]|null
	 */
	public function getProducts(): ?array
	{
		return $this->products;
	}

	/**
	 * @param Product[]|null $products
	 */
	public function setProducts(?array $products): CashOnDelivery
	{
		$this->products = $products;
		return $this;
	}


	public function toArray(): array
	{
		$this->data['cashOnDelivery'] = $this->cashOnDelivery;
		if ($this->orderNumber) $this->data['orderNumber'] = $this->orderNumber;
		if ($this->orderDate) $this->data['orderDate'] = $this->orderDate->format('Y-m-d');
		if ($this->cashOnDeliveryPaymentType) $this->data['paymentType'] = $this->cashOnDeliveryPaymentType->value;
		if ($this->products) array_walk($this->products, function ($value) {
			$this->data['products'][] = $value->toArray();
		});
		return $this->data;
	}
}
