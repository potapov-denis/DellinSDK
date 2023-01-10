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
use function func_get_args;

final class CargoItem implements Arrayable
{

	use DataAware;

	private float $weight;
	private float $length;
	private float $width;
	private float $height;
	private float $price;
	private ?string $name;

	/**
	 * Создание товарной позиции
	 *
	 * @param float $weight Вес, кг
	 * @param float $length Длина, м
	 * @param float $width Ширина, м
	 * @param float $height Высота, м
	 * @param float $price Стоимость, руб
	 * @param string|null $name Артикул грузоместа
	 */
	public function __construct(float $weight, float $length, float $width, float $height, float $price, ?string $name = null)
	{
		$this->setWeight($weight);
		$this->setLength($length);
		$this->setWidth($width);
		$this->setHeight($height);
		$this->setPrice($price);
	}

	/**
	 * Создание товарной позиции
	 *
	 * @param float $weight Вес, кг
	 * @param float $length Длина, м
	 * @param float $width Ширина, м
	 * @param float $height Высота, м
	 * @param float $price Стоимость, руб
	 * @param string|null $name Артикул грузоместа
	 *
	 */
	public static function create(float $weight, float $length, float $width, float $height, float $price, ?string $name = null): self
	{
		return new self(...func_get_args());

	}

	/**
	 * Получить вес позиции, килограммы
	 * @return float
	 */
	public function getWeight(): float
	{
		return $this->weight;
	}

	/**
	 * Задать вес позиции, килограммы
	 *
	 * @param float $weight
	 */
	public function setWeight(float $weight): void
	{
		$this->weight = $weight;
	}

	/**
	 * Получить длину позиции, метры
	 * @return float
	 */
	public function getLength(): float
	{
		return $this->length;
	}

	/**
	 * Задать длину позиции, метры
	 *
	 * @param float $length
	 */
	public function setLength(float $length): void
	{
		$this->length = $length;
	}

	/**
	 * Получить ширину позиции, метры
	 * @return float
	 */
	public function getWidth(): float
	{
		return $this->width;
	}

	/**
	 * Задать ширину позиции, метры
	 *
	 * @param float $width
	 */
	public function setWidth(float $width): void
	{
		$this->width = $width;
	}

	/**
	 * Получить высоту позиции, метры
	 * @return float
	 */
	public function getHeight(): float
	{
		return $this->height;
	}

	/**
	 * Задать высоту позиции, метры
	 *
	 * @param float $height
	 */
	public function setHeight(float $height): void
	{
		$this->height = $height;
	}

	/**
	 * Получить стоимость позиции, рубли
	 * @return float
	 */
	public function getPrice(): float
	{
		return $this->price;
	}

	/**
	 * Задать стоимость позиции, рубли
	 *
	 * @param float $price
	 */
	public function setPrice(float $price): void
	{
		$this->price = $price;
	}

	/**
	 * Получить артикул грузоместа
	 *
	 * @return string|null
	 */
	public function getName(): ?string
	{
		return $this->name;
	}

	/**
	 * Задать артикуд грузоместа
	 *
	 * @param string|null $name
	 */
	public function setName(?string $name): void
	{
		$this->name = $name;
	}


	public function toArray(): array
	{
		$this->data['weight'] = $this->weight;
		$this->data['length'] = $this->length;
		$this->data['width'] = $this->width;
		$this->data['height'] = $this->height;
		$this->data['price'] = $this->price;

		return $this->data;
	}
}
