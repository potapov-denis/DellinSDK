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


namespace Yooogi\DellinSDK\Endpoints\Marking\Entities;

use Yooogi\DellinSDK\Core\Arrayable;
use Yooogi\DellinSDK\Core\Markable;
use Yooogi\DellinSDK\Core\Traits\DataAware;
use Yooogi\DellinSDK\Core\Traits\Login;
use Yooogi\DellinSDK\Enum\ShippingLabelFormat;

abstract class MarkEntity implements Arrayable
{

	use DataAware, Login;

	private Markable $name;
	private int $count;
	private ?ShippingLabelFormat $format;


	/**
	 * Параметры массива этикеток
	 *
	 * @param Markable $name
	 * @param int $count
	 * @param ?ShippingLabelFormat $format
	 *
	 */
	public function __construct(Markable $name, int $count, ?ShippingLabelFormat $format = ShippingLabelFormat::SMALL)
	{
		$this->setName($name);
		$this->setCount($count);
		$this->setFormat($format);
	}

	/**
	 * Получить идентификатор манипуляционного знака или упаковки
	 *
	 * Доступные значения:
	 *
	 * fragile_cargo - 'хрупкий груз';
	 * this_way_up - 'верх';
	 * stack_forbidden - 'штабелирование запрещено';
	 * beacon - 'радиоизлучение'
	 *
	 * @return Markable
	 */
	public function getName(): Markable
	{
		return $this->name;
	}

	/**
	 * Установить идентификатор манипуляционного знака или упаковки
	 *
	 * @param Markable $name
	 */
	public function setName(Markable $name): self
	{
		$this->name = $name;
		return $this;
	}

	/**
	 * Количество этикеток
	 *
	 * @return int
	 */
	public function getCount(): int
	{
		return $this->count;
	}

	/**
	 * Количество этикеток
	 *
	 * @param int $count
	 */
	public function setCount(int $count): self
	{
		$this->count = $count;
		return $this;
	}

	/**
	 * Получить размер этикетки.
	 *
	 * Доступные значения: 80x50, a4.
	 *
	 * Значение по умолчанию - 80х50
	 *
	 * @return ShippingLabelFormat|null
	 */
	public function getFormat(): ?ShippingLabelFormat
	{
		return $this->format;
	}

	/**
	 * Установить размер этикетки.
	 *
	 * Доступные значения: 80x50, a4.
	 *
	 * Значение по умолчанию - 80х50
	 *
	 * @param ShippingLabelFormat|null $format
	 */
	public function setFormat(?ShippingLabelFormat $format): self
	{
		$this->format = $format;
		return $this;
	}


	public function toArray(): array
	{
		$this->data['name'] = $this->name->value;
		$this->data['format'] = $this->format->value;
		$this->data['count'] = $this->count;
		return $this->data;
	}
}