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

final class ContactPerson implements Arrayable
{
	use DataAware;

	/** @var string */
	private string $name;

	/** @var bool */
	private bool $save = false;

	/**
	 * Контактное лицо
	 *
	 * @param string $name Имя контактного лица
	 * @param bool $save Признак сохранения объекта в адресную книгу. Значение по умолчанию: 'false'.
	 */
	public function __construct(string $name, bool $save = false)
	{
		$this->setName($name);
		$this->setSave($save);
	}

	/**
	 * Контактное лицо
	 *
	 * @param string $name Имя контактного лица
	 * @param bool $save Признак сохранения объекта в адресную книгу. Значение по умолчанию: 'false'.
	 *
	 * @return static
	 */
	public static function create(string $name, bool $save = false): self
	{
		return new self(...\func_get_args());
	}

	/**
	 * @return string
	 */
	public function getName(): string
	{
		return $this->name;
	}

	/**
	 * @param string $name
	 */
	public function setName(string $name): ContactPerson
	{
		$this->name = $name;
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
	public function setSave(bool $save): ContactPerson
	{
		$this->save = $save;
		return $this;
	}


	public function toArray(): array
	{
		$this->data['name'] = $this->name;
		$this->data['save'] = $this->save;
		return $this->data;
	}
}
