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

namespace Yooogi\DellinSDK\Endpoints\OrdersInfo\Entities;

use Yooogi\DellinSDK\Core\Traits\DataAware;

/**
 * Информация по заявке на доставку до адреса получателя
 *
 */
class Sfrequest implements \Yooogi\DellinSDK\Core\Arrayable
{
	use DataAware;

	private ?int $cityID;
	private ?string $docNumber;
	private ?float $price;

	/**
	 * ID города доставки, см. метод 'Поиск населённых пунктов'
	 *
	 * @return int|null
	 */
	public function getCityID(): ?int
	{
		return $this->get('cityID');
	}

	/**
	 * Номер накладной доставки
	 *
	 * @return string|null
	 */
	public function getDocNumber(): ?string
	{
		return $this->get('docNumber');
	}

	/**
	 * Стоимость доставки
	 *
	 * @return float|null
	 */
	public function getPrice(): ?float
	{
		return (float)$this->get('price');
	}


	public function toArray(): array
	{
		return $this->data;
	}
}