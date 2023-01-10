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

final class PhoneNumber implements Arrayable
{
	use DataAware;

	/** @var string */
	private string $number;

	/** @var string */
	private ?string $ext = null;

	/** @var bool */
	private bool $save = false;

	/**
	 * Телефонный номер
	 *
	 * @param string $number Номер телефона.
	 * @param ?string $ext Номер телефона.
	 * @param bool $save Признак сохранения объекта в телефонную книгу. Значение по умолчанию: 'false'.
	 *
	 * @see https://dev.dellin.ru/api/ordering/ltl-request/#_header14
	 */
	public function __construct(string $number, ?string $ext = null, bool $save = false)
	{
		$this->setNumber($number);
		$this->setExt($ext);
		$this->setSave($save);
	}

	/**
	 * Телефонный номер
	 *
	 * @param string $number Номер телефона.
	 * @param ?string $ext Номер телефона.
	 * @param bool $save Признак сохранения объекта в телефонную книгу. Значение по умолчанию: 'false'.
	 *
	 * @return static
	 * @see https://dev.dellin.ru/api/ordering/ltl-request/#_header14
	 *
	 */
	public static function create(string $number, ?string $ext = null, bool $save = false): self
	{
		return new self(...\func_get_args());
	}

	/**
	 * @return string
	 */
	public function getNumber(): string
	{
		return $this->number;
	}

	/**
	 * @param string $number
	 */
	public function setNumber(string $number): PhoneNumber
	{
		$this->number = $number;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getExt(): ?string
	{
		return $this->ext;
	}

	/**
	 * @param string $ext
	 */
	public function setExt(?string $ext): PhoneNumber
	{
		$this->ext = $ext;
		return $this;
	}

	/**
	 * @return bool
	 */
	public function isSave(): bool
	{
		return $this->save;
	}

	/**
	 * @param bool $save
	 */
	public function setSave(bool $save): PhoneNumber
	{
		$this->save = $save;
		return $this;
	}


	public function toArray(): array
	{
		$this->data['number'] = $this->number;
		$this->data['save'] = $this->save;
		if ($this->ext) $this->data['ext'] = $this->ext;
		return $this->data;
	}
}
