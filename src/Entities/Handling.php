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

use Yooogi\DellinSDK\Core\Arrayable;
use Yooogi\DellinSDK\Core\Traits\DataAware;
use Yooogi\DellinSDK\Enum\PayerType;
use function func_get_args;

final class Handling implements Arrayable
{
	use DataAware;

	private bool $freightLift = false;
	private ?int $toFloor = null;
	private ?int $carry = null;
	private ?PayerType $payer = null;

	/**
	 * @param bool $freightLift Наличие грузового лифт
	 * @param int|null $toFloor Номера этажа, на который необходимо поднять груз
	 * @param int|null $carry Расстояние, на которое необходимо перенести груз (в метрах)
	 *
	 * @see https://dev.dellin.ru/api/calculation/calculator/#_header8
	 */
	public function __construct(bool $freightLift, ?int $toFloor = null, ?int $carry = null)
	{
		$this->setFreightLift($freightLift);
		$this->setToFloor($toFloor);
		$this->setCarry($carry);
	}

	/**
	 * @param bool $freightLift Наличие грузового лифт
	 * @param int|null $toFloor Номера этажа, на который необходимо поднять груз
	 * @param int|null $carry Расстояние, на которое необходимо перенести груз (в метрах)
	 *
	 * @return static
	 *
	 * @see https://dev.dellin.ru/api/calculation/calculator/#_header8
	 */
	public static function create(bool $freightLift, ?int $toFloor = null, ?int $carry = null): self
	{
		return new self(...func_get_args());
	}

	/**
	 * Получение наличия грузовой лифт
	 *
	 * @return bool
	 */
	public function isFreightLift(): bool
	{
		return $this->freightLift;
	}

	/**
	 * Установка наличия грузового лифта
	 *
	 * @param bool $freightLift
	 *
	 * @return Handling
	 */
	public function setFreightLift(bool $freightLift): Handling
	{
		$this->freightLift = $freightLift;
		return $this;
	}

	/**
	 * Получение номера этажа, на который необходимо поднять груз
	 *
	 * @return int|null
	 */
	public function getToFloor(): ?int
	{
		return $this->toFloor;
	}

	/**
	 * Установка номера этажа, на который необходимо поднять груз
	 *
	 * @param int|null $toFloor
	 *
	 * @return Handling
	 */
	public function setToFloor(?int $toFloor): Handling
	{
		$this->toFloor = $toFloor;
		return $this;
	}

	/**
	 * Получение расстояния, на которое необходимо перенести груз (в метрах)
	 *
	 * @return int|null
	 */
	public function getCarry(): ?int
	{
		return $this->carry;
	}

	/**
	 * Установка расстояния, на которое необходимо перенести груз (в метрах)
	 *
	 * @param int|null $carry
	 *
	 * @return Handling
	 */
	public function setCarry(?int $carry): Handling
	{
		$this->carry = $carry;
		return $this;
	}

	/**
	 * Получить плательщика по погрузочным работам
	 *
	 * @return PayerType|null
	 */
	public function getPayer(): ?PayerType
	{
		return $this->payer;
	}

	/**
	 * Установить плательщика по погрузочным работам
	 *
	 * @param PayerType|null $payer
	 */
	public function setPayer(?PayerType $payer): Handling
	{
		$this->payer = $payer;
		return $this;
	}


	public function toArray(): array
	{
		$this->data['freightLift'] = $this->freightLift;
		$this->data['carry'] = $this->carry;
		$this->data['toFloor'] = $this->toFloor;
		if ($this->payer) $this->data['payer'] = $this->payer->value;
		return $this->data;
	}
}
