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

use Yooogi\DellinSDK\Collections\CargoItemsCollection;
use Yooogi\DellinSDK\Core\Arrayable;
use Yooogi\DellinSDK\Core\GenericEntity;
use Yooogi\DellinSDK\Core\Traits\DataAware;
use Yooogi\DellinSDK\Enum\DeliveryType;
use Yooogi\DellinSDK\Enum\PayerType;
use Yooogi\DellinSDK\Exceptions\OversizeException;
use function func_get_args;

final class Cargo implements Arrayable
{
	use DataAware;

	/**
	 * @var CargoItem[]|null
	 */
	private CargoItemsCollection $items;
	private ?string $freightUID = null;
	private float $hazardClass = 0;
	private bool $insurance = false;
	private bool $termInsurance = false;
	private PayerType $payerInsurance = PayerType::SENDER;
	private int $quantity = 0;

	private array $volumes;
	private array $weights;
	private array $heights;
	private array $widths;
	private array $lengths;

	private float $oversizedWeight = 0;
	private float $oversizedVolume = 0;

	private ?string $freightName = null;

	private float $statedValue;
	private DeliveryType $deliveryType = DeliveryType::AUTO;

	/**
	 * @param CargoItemsCollection|null $items CargoItemsCollection
	 */
	public function __construct(CargoItemsCollection $items = null)
	{
		$this->items = $items;
		$this->totalRecalculation();
	}

	/**
	 * Пересчет габаритов всех мест
	 *
	 * @return void
	 */
	private function totalRecalculation(): void
	{
		$this->resetVariables();
		$this->setQuantity(count((array)$this->items));

		foreach ($this->items as $item) {

			$this->heights[] = $item->getHeight();
			$this->widths[] = $item->getWidth();
			$this->lengths[] = $item->getLength();

			$this->volumes[] = $item->getHeight() * $item->getWidth() * $item->getLength();
			$this->weights[] = $item->getWeight();

			$oversized = $this->isOversized($this->deliveryType, weight: $item->getWeight(), height: $item->getHeight(), width: $item->getWidth(), length: $item->getLength());
			if ($oversized) {
				$this->oversizeSum($item);
			}

			$this->statedValue += $item->getPrice();

		}

	}

	/**
	 * Обнуление массивов для пересчета суммарных габаритов
	 *
	 * @return void
	 */
	private function resetVariables(): void
	{
		$this->volumes = [];
		$this->weights = [];
		$this->heights = [];
		$this->widths = [];
		$this->lengths = [];
		$this->statedValue = 0;
	}

	/**
	 * Проверка на негабарит по типу доставки
	 *
	 * @param DeliveryType $deliveryType
	 * @param float $weight
	 * @param float $height
	 * @param float $width
	 * @param float $length
	 *
	 * @return bool
	 * @throws OversizeException
	 */
	private function isOversized(DeliveryType $deliveryType, float $weight, float $height, float $width, float $length): bool
	{

		if ($height >= 2.4 || $width >= 2.4) {
			throw new OversizeException('Превышен допустимый габарит 2.4 метра по ширине или высоте.');
		}


		return (array_sum(array_map(static function ($dimension, $oversize) {
				return $dimension >= $oversize;
			}, [$weight,
				$height,
				$width,
				$length], array_values($deliveryType->getOversizedDimensions()))) > 0);
	}

	/**
	 * Сумма негабаритных мест
	 *
	 * @param CargoItem $item
	 *
	 * @return void
	 */
	private function oversizeSum(CargoItem $item): void
	{
		$this->oversizedWeight += $item->getWeight();
		$this->oversizedVolume += $item->getHeight() * $item->getWidth() * $item->getLength();
	}

	/**
	 * @param CargoItemsCollection|null $items CargoItemsCollection
	 *
	 * @return Cargo
	 */
	public static function create(CargoItemsCollection $items = null): Cargo
	{
		return new self(...func_get_args());
	}

	/**
	 * @return DeliveryType
	 */
	public function getDeliveryType(): DeliveryType
	{
		return $this->deliveryType;
	}

	/**
	 * @param DeliveryType $deliveryType
	 */
	public function setDeliveryType(DeliveryType $deliveryType): void
	{
		$this->deliveryType = $deliveryType;
	}

	/**
	 * @return string
	 */
	public function getFreightUID(): string
	{
		return $this->freightUID;
	}

	/**
	 * @param string $freightUID
	 */
	public function setFreightUID(string $freightUID): self
	{
		$this->freightUID = $freightUID;
		return $this;
	}

	/**
	 * Наименование груза
	 * Характер груза
	 *
	 * @return string
	 */
	public function getFreightName(): string
	{
		return $this->freightName;
	}

	/**
	 *  Наименование груза
	 *  Характер груза
	 *
	 * @param string $freightName
	 */
	public function setFreightName(string $freightName): Cargo
	{
		$this->freightName = $freightName;
		return $this;
	}

	/**
	 * @return float
	 */
	public function getHazardClass(): float
	{
		return $this->hazardClass;
	}

	/**
	 * @param float $hazardClass
	 */
	public function setHazardClass(float $hazardClass): Cargo
	{
		$this->hazardClass = $hazardClass;
		return $this;
	}

	/**
	 * @return bool
	 */
	public function isTermInsurance(): bool
	{
		return $this->termInsurance;
	}

	/**
	 * @param bool $termInsurance
	 */
	public function setTermInsurance(bool $termInsurance): Cargo
	{
		$this->termInsurance = $termInsurance;
		return $this;
	}

	/**
	 * @return PayerType
	 */
	public function getPayerInsurance(): PayerType
	{
		return $this->payerInsurance;
	}

	/**
	 * @param PayerType $payerInsurance
	 */
	public function setPayerInsurance(PayerType $payerInsurance): Cargo
	{
		$this->payerInsurance = $payerInsurance;
		return $this;
	}

	/**
	 * @param CargoItem $item
	 *
	 * @return $this
	 */
	public function addItem(CargoItem $item): Cargo
	{
		$this->items[] = $item;
		$this->totalRecalculation();
		return $this;
	}

	/**
	 * @return int
	 */
	public function getQuantity(): int
	{
		return $this->quantity;
	}

	/**
	 * @param int $quantity
	 */
	public function setQuantity(int $quantity): Cargo
	{
		$this->quantity = ($quantity > 0) ? $quantity : 1;
		return $this;
	}

	/**
	 * @return float
	 */
	public function getStatedValue(): float
	{
		return $this->statedValue;
	}

	/**
	 * @param float $statedValue
	 */
	public function setStatedValue(float $statedValue): Cargo
	{
		$this->statedValue = $statedValue;
		return $this;
	}

	public function toArray(): array
	{

		$dimensions = $this->getDimensions();
		$this->data['totalWeight'] = (array_sum($this->weights) > 0.001) ? array_sum($this->weights) : 0.001;
		$this->data['totalVolume'] = (array_sum($this->volumes) > 0.001) ? array_sum($this->volumes) : 0.001;
		$this->data['quantity'] = $this->quantity;
		$this->data['height'] = ($dimensions->height > 0.01) ? $dimensions->height : 0.01;
		$this->data['width'] = ($dimensions->width > 0.01) ? $dimensions->width : 0.01;
		$this->data['length'] = ($dimensions->length > 0.01) ? $dimensions->length : 0.01;
		$this->data['weight'] = ($dimensions->weight > 0.001) ? $dimensions->weight : 0.001;
		$this->data['oversizedWeight'] = $this->oversizedWeight;
		$this->data['oversizedVolume'] = $this->oversizedVolume;

		if ($this->isInsurance()) {
			$this->data['insurance']['statedValue'] = $this->statedValue;
			$this->data['insurance']['payer'] = $this->payerInsurance->value;
			$this->data['insurance']['term'] = $this->termInsurance;

		}


		$this->data['hazardClass'] = $this->hazardClass;
		if ($this->freightUID) $this->data['freightUID'] = $this->freightUID;

		if ($this->freightName) {
			$this->data['freightName'] = $this->freightName;
		}
		return $this->data;
	}

	public function getDimensions()
	{
		return new GenericEntity([
			'length' => (count($this->lengths) > 0) ? (float)max($this->lengths) : 0,
			'height' => (count($this->heights) > 0) ? (float)max($this->heights) : 0,
			'width' => (count($this->widths) > 0) ? (float)max($this->widths) : 0,
			'weight' => (count($this->weights) > 0) ? (float)max($this->weights) : 0,
			'quantity' => $this->quantity,
			'totalWeight' => (float)array_sum($this->weights),
			'totalVolume' => (float)array_sum($this->volumes),
		]);
	}

	/**
	 * @return bool
	 */
	public function isInsurance(): bool
	{
		return $this->insurance;
	}

	/**
	 * @param bool $insurance
	 */
	public function setInsurance(bool $insurance): Cargo
	{
		$this->insurance = $insurance;
		return $this;
	}
}
