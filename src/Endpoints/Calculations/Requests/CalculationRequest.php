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

namespace Yooogi\DellinSDK\Endpoints\Calculations\Requests;

use Yooogi\DellinSDK\Collections\AccompanyingDocumentsCollection;
use Yooogi\DellinSDK\Collections\PackageCollection;
use Yooogi\DellinSDK\Core\Arrayable;
use Yooogi\DellinSDK\Core\MetaDatable;
use Yooogi\DellinSDK\Core\Traits\DataAware;
use Yooogi\DellinSDK\Core\Traits\Login;
use Yooogi\DellinSDK\Core\Traits\MetaData;
use Yooogi\DellinSDK\Entities\Cargo;
use Yooogi\DellinSDK\Entities\DerivalArrival;
use Yooogi\DellinSDK\Entities\Requester;
use Yooogi\DellinSDK\Enum\DeliveryType;


final class CalculationRequest implements Arrayable, MetaDatable
{
	use DataAware, Login, MetaData;

	private DerivalArrival $derival;
	private DerivalArrival $arrival;
	private Cargo $cargo;
	private array $packages = [];
	private array $accompanyingDocuments = [];
	private ?Requester $requester = null;
	private DeliveryType $deliveryType;
	private ?PackageCollection $packageCollection = null;
	private ?AccompanyingDocumentsCollection $accompanyingDocumentsCollection = null;

	/**
	 * Расчет доставки
	 *
	 * @param DeliveryType $deliveryType Тип доставки
	 * @param DerivalArrival $derival Отправитель
	 * @param DerivalArrival $arrival Получатель
	 * @param Cargo $cargo Груз
	 *
	 */
	public function __construct(DeliveryType $deliveryType, DerivalArrival $derival, DerivalArrival $arrival, Cargo $cargo)
	{
		$this->setDerival($derival);
		$this->setArrival($arrival);
		$this->setDeliveryType($deliveryType);
		$this->setCargo($cargo);
	}

	/**
	 * Расчет доставки
	 *
	 * @param DeliveryType $deliveryType Тип доставки
	 * @param DerivalArrival $derival Отправитель
	 * @param DerivalArrival $arrival Получатель
	 * @param Cargo $cargo Груз
	 *
	 * @return CalculationRequest;
	 */

	public static function create(DeliveryType $deliveryType, DerivalArrival $derival, DerivalArrival $arrival, Cargo $cargo): CalculationRequest
	{
		return new self(...func_get_args());
	}

	/**
	 * @return DerivalArrival
	 */
	public function getDerival(): DerivalArrival
	{
		return $this->derival;
	}

	/**
	 * @param DerivalArrival $derival
	 */
	public function setDerival(DerivalArrival $derival): void
	{
		$this->derival = $derival;
	}

	/**
	 * @return DerivalArrival
	 */
	public function getArrival(): DerivalArrival
	{
		return $this->arrival;
	}

	/**
	 * @param DerivalArrival $arrival
	 */
	public function setArrival(DerivalArrival $arrival): void
	{
		$this->arrival = $arrival;
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
	 * @return PackageCollection
	 */
	public function getPackages(): PackageCollection
	{
		return $this->packageCollection;
	}

	/**
	 * @param PackageCollection $packageCollection
	 *
	 * @return CalculationRequest
	 */
	public function setPackages(PackageCollection $packageCollection): CalculationRequest
	{
		$this->packageCollection = $packageCollection;
		return $this;
	}

	/**
	 * @return AccompanyingDocumentsCollection
	 */
	public function getAccompanyingDocuments(): AccompanyingDocumentsCollection
	{
		return $this->accompanyingDocumentsCollection;
	}

	/**
	 * @param AccompanyingDocumentsCollection $acDocCollection
	 *
	 * @return CalculationRequest
	 */
	public function setAccompanyingDocuments(AccompanyingDocumentsCollection $acDocCollection): CalculationRequest
	{
		$this->accompanyingDocumentsCollection = $acDocCollection;
		return $this;
	}

	public function getCargo(): Cargo
	{
		return $this->cargo;
	}

	public function setCargo(Cargo $cargo): CalculationRequest
	{
		$this->cargo = $cargo;

		return $this;
	}

	public function getRequester(): Requester
	{
		return $this->requester;
	}

	public function setRequester(Requester $requester): CalculationRequest
	{
		$this->requester = $requester;

		return $this;
	}

	public function toArray(): array
	{
		$this->data['delivery']['deliveryType']['type'] = $this->deliveryType->value;
		$this->data['delivery']['derival'] = $this->derival->toArray();
		$this->data['delivery']['arrival'] = $this->arrival->toArray();
		$this->data['cargo'] = $this->cargo->toArray();

		if ($this->packageCollection) $this->data['delivery']['packages'] = PackageCollection::renderPackages($this->packageCollection);
		if ($this->accompanyingDocumentsCollection) $this->data['delivery']['accompanyingDocuments'] = AccompanyingDocumentsCollection::renderAccompanyingDocuments
		($this->accompanyingDocumentsCollection);
		if ($this->requester) $this->data['members']['requester'] = $this->requester->toArray();
		return $this->data;
	}
}
