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

use Yooogi\DellinSDK\Collections\CargoPlacesCollection;
use Yooogi\DellinSDK\Core\Arrayable;
use Yooogi\DellinSDK\Core\Traits\DataAware;
use Yooogi\DellinSDK\Core\Traits\Login;
use function func_get_args;

final class MakeShippingLabelsRequest implements Arrayable
{
	use DataAware, Login;

	private string $orderID;
	private CargoPlacesCollection $cargoPlaces;

	/**
	 * Запрос на создание этикеток к грузоместам
	 *
	 * @param string $orderID
	 * @param CargoPlacesCollection $cargoPlaces
	 */
	public function __construct(string $orderID, CargoPlacesCollection $cargoPlaces)
	{
		$this->setOrderID($orderID);
		$this->setCargoPlaces($cargoPlaces);
	}

	/**
	 * Запрос на создание этикеток к грузоместам
	 *
	 * @param string $orderID
	 * @param CargoPlacesCollection $cargoPlaces
	 *
	 * @return MakeShippingLabelsRequest
	 */
	public static function create(string $orderID, CargoPlacesCollection $cargoPlaces): MakeShippingLabelsRequest
	{
		return new MakeShippingLabelsRequest(...func_get_args());
	}

	/**
	 * Получить заказа
	 * @return string
	 */
	public function getOrderID(): string
	{
		return $this->orderID;
	}

	/**
	 * Установить номер заказа
	 *
	 * @param string $orderID
	 */
	public function setOrderID(string $orderID): void
	{
		$this->orderID = $orderID;
	}

	/**
	 * Получить грузоместа
	 *
	 * @return CargoPlacesCollection
	 */
	public function getCargoPlaces(): CargoPlacesCollection
	{
		return $this->cargoPlaces;
	}

	/**
	 * Установить грузоместа
	 *
	 * @param CargoPlacesCollection $cargoPlaces
	 */
	public function setCargoPlaces(CargoPlacesCollection $cargoPlaces): void
	{
		$this->cargoPlaces = $cargoPlaces;
	}


	public function toArray(): array
	{
		$this->data['orderID'] = $this->orderID;

		$cargoPlaces = [];
		foreach ($this->cargoPlaces as $cargoPlace) {
			$cargoPlaces[] = $cargoPlace->toArray();
		}
		$this->data['cargoPlaces'] = $cargoPlaces;

		return $this->data;
	}
}