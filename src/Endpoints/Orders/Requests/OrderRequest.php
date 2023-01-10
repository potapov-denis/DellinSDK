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

namespace Yooogi\DellinSDK\Endpoints\Orders\Requests;

use Yooogi\DellinSDK\Collections\AccompanyingDocumentsCollection;
use Yooogi\DellinSDK\Collections\PackageCollection;
use Yooogi\DellinSDK\Core\Arrayable;
use Yooogi\DellinSDK\Core\Traits\DataAware;
use Yooogi\DellinSDK\Core\Traits\Login;
use Yooogi\DellinSDK\Core\Traits\MetaData;
use Yooogi\DellinSDK\Entities\Cargo;
use Yooogi\DellinSDK\Entities\DerivalArrival;
use Yooogi\DellinSDK\Entities\Members;
use Yooogi\DellinSDK\Entities\Payment;
use Yooogi\DellinSDK\Enum\DeliveryType;
use function func_get_args;

final class OrderRequest implements Arrayable
{
	use DataAware, Login, MetaData;

	/** @var DerivalArrival $derival */
	private DerivalArrival $derival;
	/** @var DerivalArrival $arrival */
	private DerivalArrival $arrival;
	/** @var Members $members */
	private Members $members;
	/** @var Cargo $cargo */
	private Cargo $cargo;
	/** @var Payment $payment */
	private Payment $payment;
	/** @var bool $inOrder */
	private bool $inOrder = false;
	/** @var string $cargoCode */
	private ?string $cargoCode = null;

	private DeliveryType $deliveryType;
	private ?PackageCollection $packageCollection = null;
	private ?AccompanyingDocumentsCollection $accompanyingDocumentsCollection = null;
	private array $packages = [];
	private array $accompanyingDocuments = [];

	private ?string $smsback = null;
	private ?string $comment = null;

	public function __construct(
		DeliveryType   $deliveryType,
		DerivalArrival $derival,
		DerivalArrival $arrival,
		Members        $members,
		Cargo          $cargo,
		Payment        $payment,
		bool           $inOrder = false,
		string         $cargoCode = null)
	{


		$this->setDeliveryType($deliveryType);
		$this->setDerival($derival);
		$this->setArrival($arrival);
		$this->setMembers($members);
		$this->setCargo($cargo);
		$this->setPayment($payment);
		$this->setInOrder($inOrder);
		$this->setCargoCode($cargoCode);

	}

	public static function create(
		DeliveryType   $deliveryType,
		DerivalArrival $derival,
		DerivalArrival $arrival,
		Members        $members,
		Cargo          $cargo,
		Payment        $payment,
		bool           $inOrder = false,
		string         $cargoCode = null)
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
	 * @return Members
	 */
	public function getMembers(): Members
	{
		return $this->members;
	}

	/**
	 * @param Members $members
	 */
	public function setMembers(Members $members): void
	{
		$this->members = $members;
	}

	/**
	 * @return Cargo
	 */
	public function getCargo(): Cargo
	{
		return $this->cargo;
	}

	/**
	 * @param Cargo $cargo
	 */
	public function setCargo(Cargo $cargo): void
	{
		$this->cargo = $cargo;
	}

	/**
	 * @return Payment
	 */
	public function getPayment(): Payment
	{
		return $this->payment;
	}

	/**
	 * @param Payment $payment
	 */
	public function setPayment(Payment $payment): void
	{
		$this->payment = $payment;
	}

	/**
	 * @return bool
	 */
	public function isInOrder(): bool
	{
		return $this->inOrder;
	}

	/**
	 * @param bool $inOrder
	 *
	 * @return OrderRequest
	 */
	public function setInOrder(bool $inOrder): OrderRequest
	{
		$this->inOrder = $inOrder;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getCargoCode(): ?string
	{
		return $this->cargoCode;
	}

	/**
	 * @param string $cargoCode
	 */
	public function setCargoCode(?string $cargoCode): void
	{
		$this->cargoCode = $cargoCode;
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
	 * @return OrderRequest
	 */
	public function setPackages(PackageCollection $packageCollection): OrderRequest
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
	 * @return OrderRequest
	 */
	public function setAccompanyingDocuments(AccompanyingDocumentsCollection $acDocCollection): OrderRequest
	{
		$this->accompanyingDocumentsCollection = $acDocCollection;
		return $this;
	}

	/**
	 * Телефон для SMS-уведомлений.
	 *
	 * Формат номера: '7ХХХХХХХХХХ' (11 цифр с ведущей семёркой)
	 *
	 * @return string|null
	 */
	public function getSmsback(): ?string
	{
		return $this->smsback;
	}

	/**
	 * Телефон для SMS-уведомлений.
	 *
	 * Формат номера: '7ХХХХХХХХХХ' (11 цифр с ведущей семёркой)
	 *
	 *
	 * @param string|null $smsback
	 *
	 * @return OrderRequest
	 */
	public function setSmsback(?string $smsback): OrderRequest
	{
		$this->smsback = $smsback;
		return $this;
	}

	/**
	 * Комментарий к заказу.
	 * Максимальная длина поля: 500 символов
	 *
	 * @return string|null
	 */
	public function getComment(): ?string
	{
		return $this->comment;
	}

	/**
	 * Комментарий к заказу.
	 * Максимальная длина поля: 500 символов
	 *
	 * @param string|null $comment
	 *
	 * @return OrderRequest
	 */
	public function setComment(?string $comment): OrderRequest
	{
		$this->comment = ($comment)
			? mb_strimwidth($comment, 0, 500, '', 'UTF8')
			: null;
		return $this;
	}


	public function toArray(): array
	{
		$this->data['inOrder'] = $this->inOrder;
		$this->data['delivery']['deliveryType']['type'] = $this->deliveryType->value;
		$this->data['delivery']['derival'] = $this->derival->toArray();
		$this->data['delivery']['arrival'] = $this->arrival->toArray();
		$this->data['cargo'] = $this->cargo->toArray();
		$this->data['payment'] = $this->payment->toArray();
		if ($this->members) {
			$this->members->setAuth($this->getAuth());
			$this->data['members'] = $this->members->toArray();
		}

		if ($this->packageCollection) $this->data['delivery']['packages'] = PackageCollection::renderPackages($this->packageCollection);
		if ($this->accompanyingDocumentsCollection) $this->data['delivery']['accompanyingDocuments'] = AccompanyingDocumentsCollection::renderAccompanyingDocuments
		($this->accompanyingDocumentsCollection);


		if ($this->cargo) $this->data['cargo'] = $this->cargo->toArray();

		if ($this->smsback) $this->data['delivery']['smsback'] = $this->smsback;
		if ($this->comment) $this->data['delivery']['comment'] = $this->comment;
		return $this->data;
	}

}
