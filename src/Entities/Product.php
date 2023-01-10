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
use Yooogi\DellinSDK\Enum\VATType;
use function func_get_args;


final class Product implements Arrayable
{
	use DataAware;

	private string $productName;
	private ?string $productCode;
	private int $productAmount;
	private float $costWithVAT;
	private ?VATType $VATRate;
	private bool $marking;
	private array $markingCodes;

	/**
	 * Создание товарной позиции для наложенного платежа
	 *
	 * @param string $productName Наименование товара
	 * @param int $productAmount Количество
	 * @param float $costWithVAT Цена за ед . с НДС, руб .
	 * @param string|null $productCode Номенклатурный номер(артикул)
	 * @param VATType|null $VATRate Ставка НДС, %. Если товар не облагается НДС, то следует передавать не нулевое значение, а просто не передавать параметр
	 * @param bool $marking Флаг, обозначающие, что в запросе будут переданы коды маркировки товаров по системе 'Честный знак'
	 * @param array $markingCodes Коды маркировки
	 *
	 * @see https://dev.dellin.ru/api/ordering/ltl-request/#_header18
	 */
	public function __construct(string $productName, int $productAmount, float $costWithVAT, ?string $productCode = null, ?VATType $VATRate = null, bool $marking = false,
	                            array  $markingCodes = [])
	{
		$this->setProductName($productName);
		$this->setProductAmount($productAmount);
		$this->setCostWithVAT($costWithVAT);
		$this->setProductCode($productCode);
		$this->setVATRate($VATRate);
		$this->setMarking($marking);
		$this->setMarkingCodes($markingCodes);
	}

	/**
	 * Создание товарной позиции для наложенного платежа
	 *
	 * @param string $productName Наименование товара
	 * @param int $productAmount Количество
	 * @param float $costWithVAT Цена за ед . с НДС, руб .
	 * @param string|null $productCode Номенклатурный номер(артикул)
	 * @param VATType|null $VATRate Ставка НДС, %. Если товар не облагается НДС, то следует передавать не нулевое значение, а просто не передавать параметр
	 * @param bool $marking Флаг, обозначающие, что в запросе будут переданы коды маркировки товаров по системе 'Честный знак'
	 * @param array $markingCodes Коды маркировки
	 *
	 * @see https://dev.dellin.ru/api/ordering/ltl-request/#_header18
	 */
	public static function create(string $productName, int $productAmount, float $costWithVAT, ?string $productCode = null, ?VATType $VATRate = null, bool $marking = false,
	                              array  $markingCodes = []): self
	{
		return new self(...func_get_args());
	}

	/**
	 * @return string
	 */
	public function getProductName(): string
	{
		return $this->productName;
	}

	/**
	 * @param string $productName
	 */
	public function setProductName(string $productName): Product
	{
		$this->productName = $productName;
		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getProductCode(): ?string
	{
		return $this->productCode;
	}

	/**
	 * @param string|null $productCode
	 */
	public function setProductCode(?string $productCode): Product
	{
		$this->productCode = $productCode;
		return $this;
	}

	/**
	 * @return int
	 */
	public function getProductAmount(): int
	{
		return $this->productAmount;
	}

	/**
	 * @param int $productAmount
	 */
	public function setProductAmount(int $productAmount): Product
	{
		$this->productAmount = $productAmount;
		return $this;
	}

	/**
	 * @return float
	 */
	public function getCostWithVAT(): float
	{
		return $this->costWithVAT;
	}

	/**
	 * @param float $costWithVAT
	 */
	public function setCostWithVAT(float $costWithVAT): Product
	{
		$this->costWithVAT = $costWithVAT;
		return $this;
	}

	/**
	 * @return VATType|null
	 */
	public function getVATRate(): ?VATType
	{
		return $this->VATRate;
	}

	/**
	 * @param VATType|null $VATRate
	 */
	public function setVATRate(?VATType $VATRate): Product
	{
		$this->VATRate = $VATRate;
		return $this;
	}

	/**
	 * @return bool
	 */
	public function isMarking(): bool
	{
		return $this->marking;
	}

	/**
	 * @param bool $marking
	 */
	public function setMarking(bool $marking): Product
	{
		$this->marking = $marking;
		return $this;
	}

	/**
	 * @return array
	 */
	public function getMarkingCodes(): array
	{
		return $this->markingCodes;
	}

	/**
	 * @param array $markingCodes
	 */
	public function setMarkingCodes(array $markingCodes): Product
	{
		$this->markingCodes = $markingCodes;
		return $this;
	}

	public function toArray(): array
	{
		$this->data['productName'] = $this->productName;
		$this->data['productAmount'] = $this->productAmount;
		$this->data['costWithVAT'] = $this->costWithVAT;
		if ($this->productCode) $this->data['productCode'] = $this->productCode;
		if ($this->VATRate) $this->data['VATRate'] = $this->VATRate->value;
		if ($this->marking) {
			$this->data['marking'] = $this->marking;
			$this->data['markingCodes'] = $this->markingCodes;
		}
		return $this->data;
	}
}
