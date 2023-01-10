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

namespace Yooogi\DellinSDK\Endpoints\OrdersInfo\Entities;

use DateTimeImmutable;
use Yooogi\DellinSDK\Core\Arrayable;
use Yooogi\DellinSDK\Core\ArrayOf;
use Yooogi\DellinSDK\Core\Traits\DataAware;
use Yooogi\DellinSDK\Endpoints\OrdersInfo\Entities\Traits\{FreightTrait, MembersTrait, PaymentTrait};
use Yooogi\DellinSDK\Enum\OrderDocumentStateType;
use Yooogi\DellinSDK\Enum\OrderDocumentType;
use Yooogi\DellinSDK\Instantiator;

class Documents implements Arrayable
{
	use DataAware, MembersTrait, FreightTrait, PaymentTrait;

	private ?string $id;
	private ?string $uid;
	private OrderDocumentType $type;
	private ?DateTimeImmutable $createDate;
	private OrderDocumentStateType $state;
	private DocumentDerivalArrival $derival;
	private DocumentDerivalArrival $arrival;
	private ?DateTimeImmutable $produceDate;
	private ?string $forwarderId;
	private ?string $comment;
	private ?string $fullDocumentId;
	private ?string $barcode;
	private bool $payment;
	private ?string $debtSum;
	private ?string $serviceKind;
	private ?string $organization;
	private ?Services $services;
	private array $availableDocs;
	private array $accompanyingDocuments;

	/**
	 * @return string|null
	 */
	public function getId(): ?string
	{
		return (string)$this->get('id');
	}

	/**
	 * @return string|null
	 */
	public function getUid(): ?string
	{
		return (string)$this->get('uid');
	}

	/**
	 * @return OrderDocumentType|null
	 */
	public function getType(): ?OrderDocumentType
	{
		return OrderDocumentType::TryFrom($this->get('type'));
	}

	/**
	 * @return DateTimeImmutable|null
	 */
	public function getCreateDate(): ?DateTimeImmutable
	{
		return $this->get('createDate')
			? DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $this->get('createDate'))
			: null;
	}

	/**
	 * @return OrderDocumentStateType|null
	 */
	public function getState(): ?OrderDocumentStateType
	{
		return OrderDocumentStateType::TryFrom(preg_replace('/[\s]/ui', '_', $this->get('state')));
	}

	/**
	 * @return DocumentDerivalArrival
	 */
	public function getDerival(): DocumentDerivalArrival
	{
		return Instantiator::instantiate(DocumentDerivalArrival::class, $this->get('derival'));
	}

	/**
	 * @return DocumentDerivalArrival
	 */
	public function getArrival(): DocumentDerivalArrival
	{
		return Instantiator::instantiate(DocumentDerivalArrival::class, $this->get('arrival'));
	}

	/**
	 * @return ?DateTimeImmutable
	 */
	public function getProduceDate(): ?DateTimeImmutable
	{
		return $this->get('produceDate')
			? DateTimeImmutable::createFromFormat('Y-m-d', $this->get('produceDate'))
			: null;
	}

	/**
	 * @return string|null
	 */
	public function getForwarderId(): ?string
	{
		return $this->get('forwarderId');
	}

	/**
	 * @return string|null
	 */
	public function getComment(): ?string
	{
		return $this->get('comment');
	}

	/**
	 * @return string|null
	 */
	public function getFullDocumentId(): ?string
	{
		return $this->get('fullDocumentId');
	}

	/**
	 * @return string|null
	 */
	public function getBarcode(): ?string
	{
		return $this->get('barcode');
	}

	/**
	 * @return string|null
	 */
	public function getServiceKind(): ?string
	{
		return $this->get('serviceKind');
	}

	/**
	 * @return string|null
	 */
	public function getOrganization(): ?string
	{
		return $this->get('organization');
	}

	/**
	 * @return Services[]|null
	 */
	public function getServices(): ?array
	{
		return Instantiator::instantiate(new ArrayOf(Services::class), $this->get('services'));
	}

	/**
	 * @return array
	 */
	public function getAvailableDocs(): array
	{
		return (array)$this->get('availableDocs');
	}

	/**
	 * @return AcDocs[]|null
	 */
	public function getAccompanyingDocuments(): ?array
	{
		return Instantiator::instantiate(new ArrayOf(AcDocs::class), $this->get('accompanyingDocuments'));
	}

	/**
	 * @return bool
	 */
	public function getPayment(): bool
	{
		return (bool)$this->get('payment');
	}


	/**
	 * @return string|null
	 */
	public function getDebtSum(): ?string
	{
		return $this->get('debtSum');
	}


	public function toArray(): array
	{
		return $this->data;
	}
}