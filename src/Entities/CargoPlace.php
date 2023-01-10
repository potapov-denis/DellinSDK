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
use function func_get_args;

final class CargoPlace implements Arrayable
{

	use DataAware;

	private ?string $cargoPlace = null;
	private int $amount = 1;

	/**
	 * Создание товарной позиции
	 *
	 * @param string|null $cargoPlace cargoPlace Артикул грузоместа
	 * @param int $amount Количество грузовых мест с одинаковым артикулом
	 */
	public function __construct(?string $cargoPlace = null, int $amount = 1)
	{
		$this->setCargoPlace($cargoPlace);
		$this->setAmount($amount);
	}

	/**
	 * Создание товарной позиции
	 *
	 * @param string|null $cargoPlace Артикул грузоместа
	 * @param int $amount Количество грузовых мест с одинаковым артикулом
	 *
	 */
	public static function create(?string $cargoPlace = null, int $amount = 1): self
	{
		return new self(...func_get_args());

	}

	/**
	 * @return string|null
	 */
	public function getCargoPlace(): ?string
	{
		return $this->cargoPlace;
	}

	/**
	 * @param string|null $cargoPlace
	 */
	public function setCargoPlace(?string $cargoPlace): void
	{
		$this->cargoPlace = $cargoPlace;
	}

	/**
	 * @return int
	 */
	public function getAmount(): int
	{
		return $this->amount;
	}

	/**
	 * @param int $amount
	 */
	public function setAmount(int $amount): void
	{
		$this->amount = $amount;
	}


	public function toArray(): array
	{
		$this->data['cargoPlace'] = $this->cargoPlace;
		$this->data['amount'] = $this->amount;

		return $this->data;
	}
}
