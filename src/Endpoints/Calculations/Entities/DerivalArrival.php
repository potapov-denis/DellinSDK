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

/**
 * Данные по доставке груза от отправителя
 * Данные по доставке груза до получателя
 *
 * @see https://dev.dellin.ru/api/calculation/calculator/#_header18
 */
final class DerivalArrival
{
	use DataAware;

	private float $price;
	private string $terminal;
	private float $servicePrice;
	private bool $contractPrice;


	public function __construct($derival)
	{
		$this->data = $derival;
	}

	/**
	 * Итоговая стоимость доставки от отправителя/до получателя
	 *
	 * @return float|null
	 */
	public function getPrice(): ?float
	{
		return (float)$this->get('price');
	}

	/**
	 * Стоимость услуги доставки груза от адреса отправителя/до адреса получателя (без учёта скидок и наценок)
	 *
	 * @return float|null
	 */
	public function getServicePrice(): ?float
	{
		return (float)$this->get('servicePrice');
	}

	/**
	 * Флаг, обозначающий, что стоимость доставки является договорной. Если стоимость договорная (значение параметра - 'true'),
	 * то значение параметров 'price' и 'servicePrice' - 'null',
	 * информация о наценках и скидках отсутствует (массивы 'premiumDetails' и 'discountDetails' - пустые)
	 *
	 * @return bool|null
	 */
	public function getContractPrice(): ?bool
	{
		return $this->get('contractPrice');
	}

	/**
	 * Ближайший населённый пункт к адресу получателя, в котором имеется терминал
	 *
	 * @return string|null
	 */
	public function getTerminal(): ?string
	{
		return $this->get('terminal');
	}

	/**
	 * Суммарный размер наценок на услуги (при наличии)
	 *
	 * @return float|null
	 */
	public function getPremium(): ?float
	{
		return (float)$this->get('premium');
	}

	/**
	 * Суммарный размер скидок на услуги (при наличии)
	 *
	 * @return float|null
	 */
	public function getDiscount(): ?float
	{
		return (float)$this->get('discount');
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

	/**
	 *    Информация о терминалах, где может быть выдан/сдан груз
	 *
	 * @return Terminal[]|null
	 */
	public function getTerminals(): ?array
	{
		return Instantiator::instantiate(new ArrayOf(Terminal::class), $this->get('terminals'));
	}

	/**
	 * Информация о стоимости погрузо-разгрузочных работ
	 *
	 * @return CostsCalculation|null
	 */
	public function getHandling(): ?CostsCalculation
	{
		return Instantiator::instantiate(CostsCalculation::class, $this->get('handling'));
	}


}
