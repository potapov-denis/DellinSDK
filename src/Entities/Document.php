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
use Yooogi\DellinSDK\Enum\DocumentType;


final class Document implements Arrayable
{
	use DataAware;

	private DocumentType $type;
	private ?string $serial;
	private ?string $number;

	/**
	 * @param DocumentType $type Тип документа.
	 * @param ?string $serial Серия документа. *Для некоторых стран параметр не является обязательным и игнорируется
	 * @param ?string $number Номер документа. Формат номера зависит от страны
	 *
	 * @see https://dev.dellin.ru/api/ordering/ltl-request/#_header15
	 */
	public function __construct(DocumentType $type, ?string $serial, ?string $number)
	{
		$this->setType($type);
		$this->setSerial($serial);
		$this->setNumber($number);
	}

	/**
	 * @param DocumentType $type Тип документа.
	 * @param ?string $serial Серия документа. *Для некоторых стран параметр не является обязательным и игнорируется
	 * @param ?string $number Номер документа. Формат номера зависит от страны
	 *
	 * @see https://dev.dellin.ru/api/ordering/ltl-request/#_header15
	 */
	public static function create(DocumentType $type, ?string $serial, ?string $number): self
	{
		return new self(...\func_get_args());
	}

	/**
	 * @return DocumentType
	 */
	public function getType(): DocumentType
	{
		return $this->type;
	}

	/**
	 * @param DocumentType $type
	 */
	public function setType(DocumentType $type): Document
	{
		$this->type = $type;
		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getSerial(): ?string
	{
		return $this->serial;
	}

	/**
	 * @param string|null $serial
	 */
	public function setSerial(?string $serial): Document
	{
		$this->serial = $serial;
		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getNumber(): ?string
	{
		return $this->number;
	}

	/**
	 * @param string|null $number
	 */
	public function setNumber(?string $number): Document
	{
		$this->number = $number;
		return $this;
	}


	public function toArray(): array
	{
		$this->data['type'] = $this->type->value;
		if ($this->serial) $this->data['serial'] = $this->serial;
		if ($this->number) $this->data['number'] = $this->number;

		return $this->data;
	}
}
