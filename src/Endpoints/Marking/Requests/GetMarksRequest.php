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

declare (strict_types=1);

namespace Yooogi\DellinSDK\Endpoints\Marking\Requests;

use Yooogi\DellinSDK\Core\Arrayable;
use Yooogi\DellinSDK\Core\Paginatable;
use Yooogi\DellinSDK\Core\Traits\DataAware;
use Yooogi\DellinSDK\Core\Traits\Login;
use Yooogi\DellinSDK\Core\Traits\Pagination;
use Yooogi\DellinSDK\Endpoints\Marking\Entities\HandlingMark;
use Yooogi\DellinSDK\Endpoints\Marking\Entities\PackagingMark;
use Yooogi\DellinSDK\Enum\ShippingLabelType;

abstract class GetMarksRequest implements Arrayable, Paginatable
{
	use DataAware, Pagination, Login;

	protected array $marks;
	private bool $oneFile = false;
	private ?ShippingLabelType $type = null;

	/**
	 * Запрос получение этикеток с типами упаковки
	 *
	 * @param PackagingMark[]|HandlingMark[] $marks
	 *
	 */
	public function __construct(array $marks, bool $oneFile = false, ?ShippingLabelType $type = null)
	{
		$this->setMarks($marks);
		$this->setOneFile($oneFile);
		$this->setType($type);
	}

	/**
	 * Получить тип файла с этикетками
	 *
	 * @return ShippingLabelType|null
	 */
	public function getType(): ?ShippingLabelType
	{
		return $this->type;
	}

	/**
	 * Установить тип файла с этикетками
	 *
	 * @param ShippingLabelType|null $type
	 */
	public function setType(?ShippingLabelType $type): void
	{
		$this->type = $type;
	}

	/**
	 * Получить параметры массива этикеток
	 *
	 * @return array
	 */
	public function getMarks(): array
	{
		return $this->marks;
	}

	/**
	 * Установить параметры массива этикеток
	 *
	 * @param array $marks
	 */
	public function setMarks(array $marks): void
	{
		$this->marks = $marks;
	}

	/**
	 *
	 * Флаг, позволяющий выбрать, сформировать один многостраничный документ (по одной этикетке на страницу) или сформировать отдельные файлы.
	 *
	 * Доступные значения:
	 *
	 * true - cформировать один многостраничный документ. Передача значения возможна, только если значение параметра 'type' - 'pdf';
	 * false - сформировать отдельные файлы.
	 * Значение по умолчанию - false
	 *
	 * @return bool
	 */
	public function isOneFile(): bool
	{
		return $this->oneFile;
	}

	/**
	 *
	 * Флаг, позволяющий выбрать, сформировать один многостраничный документ (по одной этикетке на страницу) или сформировать отдельные файлы.
	 *
	 * Доступные значения:
	 *
	 * true - cформировать один многостраничный документ. Передача значения возможна, только если значение параметра 'type' - 'pdf';
	 * false - сформировать отдельные файлы.
	 * Значение по умолчанию - false
	 *
	 * @param bool $oneFile
	 */
	public function setOneFile(bool $oneFile): self
	{
		$this->oneFile = $oneFile;
		return $this;
	}


	public function toArray(): array
	{
		if ($this->oneFile) $this->data['oneFile'] = $this->oneFile;
		if ($this->type) $this->data['type'] = $this->type->value;
		if ($this->per) $this->data['per'] = $this->per;
		if ($this->page) $this->data['page'] = $this->page;


		return $this->data;
	}
}