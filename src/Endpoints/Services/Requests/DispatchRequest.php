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
use Yooogi\DellinSDK\Entities\DerivalArrival;
use Yooogi\DellinSDK\Enum\DeliveryType;


abstract class DispatchRequest implements Arrayable
{
	use DataAware, Login;

	protected DeliveryType $deliveryType;
	protected DerivalArrival $derival;

	/**
	 * @param DeliveryType $deliveryType
	 * @param DerivalArrival $derival
	 */
	public function __construct(DeliveryType $deliveryType, DerivalArrival $derival)
	{
		$this->setDeliveryType($deliveryType);
		$this->setDerival($derival);

	}

	/**
	 * Информация о виде межтерминальной перевозки груза
	 *
	 * @return DeliveryType
	 */
	public function getDeliveryType(): DeliveryType
	{
		return $this->deliveryType;
	}

	/**
	 * Информация о виде межтерминальной перевозки груза
	 *
	 * @param DeliveryType $deliveryType
	 */
	public function setDeliveryType(DeliveryType $deliveryType): void
	{
		$this->deliveryType = $deliveryType;
	}

	/**
	 * Информация о доставке от адреса отправителя
	 *
	 * @return DerivalArrival
	 */
	public function getDerival(): DerivalArrival
	{
		return $this->derival;
	}

	/**
	 * Информация о доставке от адреса отправителя
	 *
	 * @param DerivalArrival $derival
	 */
	public function setDerival(DerivalArrival $derival): void
	{
		$this->derival = $derival;
	}


	public function toArray(): array
	{
		$this->data['delivery']['deliveryType']['type'] = $this->deliveryType->value;
		$this->data['delivery']['derival'] = $this->derival->toArray();
		return $this->data;
	}
}
