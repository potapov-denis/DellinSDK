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

/**
 * Информация о грузе
 *
 * @see https://dev.dellin.ru/api/orders/search/#_header14
 */
class Freight implements Arrayable
{
	use DataAware;

	private string $name;
	private string|float $weight;
	private string|float $oversizedWeight;
	private string|float $volume;
	private string|float $oversizedVolume;
	private int $places;
	private int $oversizedPlaces;
	private string $length;
	private string $width;
	private string $height;
	private float $maxLength;
	private float $maxWidth;
	private float $maxHeight;

	/**
	 * Характер груза
	 *
	 * @return string
	 */
	public function getName(): string
	{
		return $this->get('name');
	}

	/**
	 * Вес груза, кг
	 *
	 * @return float
	 */
	public function getWeight(): float
	{
		return (float)$this->get('weight');
	}

	/**
	 * Вес негабаритных грузовых мест, кг (1)
	 *
	 * @return float
	 */
	public function getOversizedWeight(): float
	{
		return (float)$this->get('oversizedWeight');
	}

	/**
	 * Объем груза, м3
	 *
	 * @return float|string
	 */
	public function getVolume(): float
	{
		return (float)$this->get('volume');
	}

	/**
	 * Объем негабаритных грузовых мест, м3 (1)
	 *
	 * @return float
	 */
	public function getOversizedVolume(): float
	{
		return (float)$this->get('oversizedVolume');
	}

	/**
	 * Количество грузовых мест
	 *
	 * @return int
	 */
	public function getPlaces(): int
	{
		return (int)$this->get('places');
	}

	/**
	 * Количество негабаритных грузовых мест (1)
	 * @return int
	 */
	public function getOversizedPlaces(): int
	{
		return (int)$this->get('oversizedPlaces');
	}

	/**
	 * Длина груза, м
	 *
	 * @return float|null
	 */
	public function getLength(): ?float
	{
		return $this->get('length') ? (float)$this->get('length') : null;
	}

	/**
	 * Ширина груза, м
	 *
	 * @return float|null
	 */
	public function getWidth(): ?float
	{
		return $this->get('width') ? (float)$this->get('width') : null;
	}

	/**
	 * Высота груза, м
	 *
	 * @return float|null
	 */
	public function getHeight(): ?float
	{
		return $this->get('height') ? (float)$this->get('height') : null;
	}

	/**
	 * Длина груза, м
	 * Только для
	 * @return float|null
	 */
	public function getMaxLength(): ?float
	{
		return $this->get('maxLength') ? (float)$this->get('maxLength') : null;
	}

	/**
	 * Ширина груза, м
	 *
	 * @return float|null
	 */
	public function getMaxWidth(): ?float
	{
		return $this->get('maxWidth') ? (float)$this->get('maxWidth') : null;
	}

	/**
	 * Высота груза, м
	 *
	 * @return float|null
	 */
	public function getMaxHeight(): ?float
	{
		return $this->get('maxHeight') ? (float)$this->get('maxHeight') : null;
	}


	public function toArray(): array
	{
		return $this->data;
	}
}