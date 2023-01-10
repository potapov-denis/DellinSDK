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

namespace Yooogi\DellinSDK\Endpoints\Services\Requests;

use Yooogi\DellinSDK\Core\Arrayable;
use Yooogi\DellinSDK\Core\Traits\DataAware;
use Yooogi\DellinSDK\Core\Traits\Login;
use Yooogi\DellinSDK\Entities\Cargo;


/**
 * Запрос на получение доступных упаковок по маршруту перевозки
 *
 * @see https://dev.dellin.ru/api/catalogs/available-packages/
 */
final class AvailablePackagesRequest implements Arrayable
{
	use DataAware, Login;

	private string $derivalPoint;
	private string $arrivalPoint;
	private int $length;
	private int $width;
	private int $height;
	private int $weight;
	private int $quantity;
	private Cargo $cargo;

	/**
	 *  Запрос на получение доступных упаковок по маршруту перевозки
	 *
	 * @param string $derivalPoint Код КЛАДР пункта прибытия груза/пункта отправки груза. Может быть указан код КЛАДР города или улицы.
	 * @param string $arrivalPoint Код КЛАДР может быть получен с помощью сервисов, представленных на странице 'Поиск КЛАДР'
	 * @param int $length Длина груза, м
	 * @param int $width Ширина груза, м
	 * @param int $height Высота груза, м
	 * @param int $weight Вес груза, кг
	 * @param int $quantity Количество грузовых мест, шт.
	 *
	 * @see @see https://dev.dellin.ru/api/catalogs/available-packages/
	 */
	public function __construct(string $derivalPoint, string $arrivalPoint, int $length, int $width, int $height, int $weight, int $quantity)
	{
		$this->setDerivalPoint($derivalPoint);
		$this->setArrivalPoint($arrivalPoint);
		$this->setLength($length);
		$this->setWidth($width);
		$this->setHeight($height);
		$this->setWeight($weight);
		$this->setQuantity($quantity);
	}

	/**
	 * Создать запрос используя сущность Cargo
	 *
	 * @param $derivalPoint
	 * @param $arrivalPoint
	 * @param Cargo $cargo
	 *
	 * @return static
	 */
	public static function createFromCargo($derivalPoint, $arrivalPoint, Cargo $cargo): self
	{
		$dimensions = $cargo->getDimensions();
		return new self($derivalPoint, $arrivalPoint, $dimensions->length, $dimensions->width, $dimensions->height, $dimensions->weight,
			$dimensions->quantity);
	}

	/**
	 *  Запрос на получение доступных упаковок по маршруту перевозки
	 *
	 * @param string $derivalPoint Код КЛАДР пункта прибытия груза/пункта отправки груза. Может быть указан код КЛАДР города или улицы.
	 * @param string $arrivalPoint Код КЛАДР может быть получен с помощью сервисов, представленных на странице 'Поиск КЛАДР'
	 * @param int $length Длина груза, м
	 * @param int $width Ширина груза, м
	 * @param int $height Высота груза, м
	 * @param int $weight Вес груза, кг
	 * @param int $quantity Количество грузовых мест, шт.
	 *
	 * @return static
	 *
	 * @see @see https://dev.dellin.ru/api/catalogs/available-packages/
	 */
	public static function create($derivalPoint, $arrivalPoint, $length, $width, $height, $weight, $quantity): self
	{
		return new self(...\func_get_args());
	}

	/**
	 * Код КЛАДР пункта прибытия груза/пункта отправки груза. Может быть указан код КЛАДР города или улицы.
	 *
	 * @return string
	 */
	public function getDerivalPoint(): string
	{
		return $this->derivalPoint;
	}

	/**
	 * Код КЛАДР пункта прибытия груза/пункта отправки груза. Может быть указан код КЛАДР города или улицы.
	 *
	 * @param string $derivalPoint
	 */
	public function setDerivalPoint(string $derivalPoint): void
	{
		$this->derivalPoint = $derivalPoint;
	}

	/**
	 * Код КЛАДР может быть получен с помощью сервисов, представленных на странице 'Поиск КЛАДР'
	 *
	 * @return string
	 */
	public function getArrivalPoint(): string
	{
		return $this->arrivalPoint;
	}

	/**
	 * Код КЛАДР может быть получен с помощью сервисов, представленных на странице 'Поиск КЛАДР'
	 *
	 * @param string $arrivalPoint
	 */
	public function setArrivalPoint(string $arrivalPoint): void
	{
		$this->arrivalPoint = $arrivalPoint;
	}

	/**
	 * Длина груза, м
	 *
	 * @return int
	 */
	public function getLength(): int
	{
		return $this->length;
	}

	/**
	 * Длина груза, м
	 *
	 * @param int $length
	 */
	public function setLength(int $length): void
	{
		$this->length = $length;
	}

	/**
	 * Ширина груза, м
	 *
	 * @return int
	 */
	public function getWidth(): int
	{
		return $this->width;
	}

	/**
	 * Ширина груза, м
	 *
	 * @param int $width
	 */
	public function setWidth(int $width): void
	{
		$this->width = $width;
	}

	/**
	 * Высота груза, м
	 *
	 * @return int
	 */
	public function getHeight(): int
	{
		return $this->height;
	}

	/**
	 * Высота груза, м
	 *
	 * @param int $height
	 */
	public function setHeight(int $height): void
	{
		$this->height = $height;
	}

	/**
	 * Вес груза, кг
	 *
	 * @return int
	 */
	public function getWeight(): int
	{
		return $this->weight;
	}

	/**
	 * Вес груза, кг
	 *
	 * @param int $weight
	 */
	public function setWeight(int $weight): void
	{
		$this->weight = $weight;
	}

	/**
	 * Количество грузовых мест, шт.
	 *
	 * @return int
	 */
	public function getQuantity(): int
	{
		return $this->quantity;
	}

	/**
	 * Количество грузовых мест, шт.
	 *
	 * @param int $quantity
	 */
	public function setQuantity(int $quantity): void
	{
		$this->quantity = $quantity;
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
	 * @return array
	 */
	public function toArray(): array
	{
		$this->data['derivalPoint'] = $this->derivalPoint;
		$this->data['arrivalPoint'] = $this->arrivalPoint;
		$this->data['length'] = $this->length;
		$this->data['height'] = $this->height;
		$this->data['width'] = $this->width;
		$this->data['weight'] = $this->weight;
		$this->data['quantity'] = $this->quantity;
		return $this->data;
	}
}
