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

use Yooogi\DellinSDK\Core\Arrayable;
use Yooogi\DellinSDK\Core\Traits\DataAware;
use Yooogi\DellinSDK\Enum\DocumentType;
use Yooogi\DellinSDK\Instantiator;


/**
 *
 * @see https://dev.dellin.ru/api/orders/search/#_header13
 */
final class Member implements Arrayable
{

	use DataAware;

	private string|Opf|null $opf;
	private string $opfUid;
	private string $name;
	private string $address;
	private bool $isPhysical;
	private string $inn;
	private DocumentType $documentType;
	private string $documentSeries;
	private string $documentNumber;
	private string $counteragentUid;
	private string $contacts;
	private string $phones;
	private bool $anonym;
	private string $anonymEmail;
	private string $anonymPhone;

	/**
	 * @return string|Opf|null
	 */
	public function getOpf(): string|Opf|null
	{
		return (is_string($this->get('opf'))) ? $this->get('opf') : Instantiator::instantiate(Opf::class, $this->get('opf'));
	}

	/**
	 * @return string
	 */
	public function getName(): string
	{
		return $this->get('name');
	}

	/**
	 * @return string
	 */
	public function getAddress(): string
	{
		return $this->get('address');
	}

	/**
	 * @return bool
	 */
	public function isPhysical(): bool
	{
		return $this->get('isPhysical');
	}

	/**
	 * @return string
	 */
	public function getInn(): string
	{
		return $this->get('inn');
	}

	/**
	 * @return DocumentType
	 */
	public function getDocumentType(): DocumentType
	{
		return DocumentType::TryFrom($this->get('documentType'));
	}

	/**
	 * @return string
	 */
	public function getDocumentSeries(): string
	{
		return $this->get('documentSeries');
	}

	/**
	 * @return string
	 */
	public function getDocumentNumber(): string
	{
		return $this->get('documentNumber');
	}

	/**
	 * @return string
	 */
	public function getCounteragentUid(): string
	{
		return $this->get('counteragentUid');
	}

	/**
	 * @return string
	 */
	public function getContacts(): string
	{
		return $this->get('contacts');
	}

	/**
	 * @return string
	 */
	public function getPhones(): string
	{
		return $this->get('phones');
	}

	/**
	 * @return bool
	 */
	public function isAnonym(): bool
	{
		return $this->get('anonym');
	}

	/**
	 * @return string
	 */
	public function getAnonymEmail(): string
	{
		return $this->get('anonymEmail');
	}

	/**
	 * @return string
	 */
	public function getAnonymPhone(): string
	{
		return $this->get('anonymPhone');
	}


	public function toArray(): array
	{
		return $this->data;
	}
}