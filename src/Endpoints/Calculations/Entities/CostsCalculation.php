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

namespace Yooogi\DellinSDK\Endpoints\Calculations\Entities;

use Yooogi\DellinSDK\Core\ArrayOf;
use Yooogi\DellinSDK\Core\Traits\DataAware;
use Yooogi\DellinSDK\Instantiator;

class CostsCalculation
{
	use DataAware;

	private float $price;
	private bool $contractPrice;
	private string $premium;
	private string $discount;
	private ?string $terminal;

	public function __construct($costsCalculation)
	{
		$this->data = $costsCalculation;
	}

	/**
	 * Итоговая стоимость для выбранного вида перевозки
	 *
	 * @return float|null
	 */
	public function getPrice(): ?float
	{
		return (float)$this->get('price');
	}


	/**
	 * Флаг, обозначающий, что стоимость доставки является договорной.
	 * Если стоимость договорная (значение параметра - 'true'), то значение параметров 'price' и 'servicePrice' - 'null',
	 * информация о наценках и скидках отсутствует (массивы 'premiumDetails' и 'discountDetails' - пустые)
	 *
	 * @return bool|null
	 */
	public function getContractPrice(): ?bool
	{
		return (bool)$this->get('contractPrice');
	}

	/**
	 * Размер наценки по услуге
	 *
	 * @return float|null
	 */
	public function getPremium(): ?float
	{
		return (float)$this->get('premium');
	}

	/**
	 * Размер скидки по услуге
	 *
	 * @return float|null
	 */
	public function getDiscount(): ?float
	{
		return (float)$this->get('discount');
	}

	/**
	 * Город, в котором расположен терминал
	 *
	 * @return string|null
	 */
	public function getTerminal(): ?string
	{
		return $this->get('terminal');
	}


	/**
	 * Подробная информация о наценках по услуге
	 *
	 * @return PriceDetail[]|null
	 */
	public function getPremiumDetails(): ?array
	{
		return Instantiator::instantiate(new ArrayOf(PriceDetail::class), $this->get('premiumDetails'));
	}

	/**
	 * Подробная информация о скидках по услуге
	 *
	 * @return PriceDetail[]|null
	 */
	public function getDiscountDetails(): ?array
	{
		return Instantiator::instantiate(new ArrayOf(PriceDetail::class), $this->get('discountDetails'));
	}
}
