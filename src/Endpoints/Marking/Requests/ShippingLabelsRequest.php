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
use Yooogi\DellinSDK\Enum\ShippingLabelFormat;
use Yooogi\DellinSDK\Enum\ShippingLabelType;

abstract class ShippingLabelsRequest implements Arrayable, Paginatable
{
	use DataAware, Login, Pagination;

	private string $orderID;
	private ?ShippingLabelType $type = null;
	private ?ShippingLabelFormat $format = null;


	/**
	 * Запрос получение этикеток на груз
	 *
	 * @param string $orderID
	 */
	public function __construct(string $orderID)
	{
		$this->setOrderID($orderID);
	}

	/**
	 * @return string
	 */
	public function getOrderID(): string
	{
		return $this->orderID;
	}

	/**
	 * @param string $orderID
	 */
	public function setOrderID(string $orderID): ShippingLabelsRequest
	{
		$this->orderID = $orderID;
		return $this;
	}

	/**
	 * @return ShippingLabelType|null
	 */
	public function getType(): ?ShippingLabelType
	{
		return $this->type;
	}

	/**
	 * @param ShippingLabelType|null $type
	 */
	public function setType(?ShippingLabelType $type): ShippingLabelsRequest
	{
		$this->type = $type;
		return $this;
	}

	/**
	 * @return ShippingLabelFormat|null
	 */
	public function getFormat(): ?ShippingLabelFormat
	{
		return $this->format;
	}

	/**
	 * @param ShippingLabelFormat|null $format
	 */
	public function setFormat(?ShippingLabelFormat $format): ShippingLabelsRequest
	{
		$this->format = $format;
		return $this;
	}


	public function toArray(): array
	{
		$this->data['orderID'] = $this->orderID;
		if ($this->type) $this->data['type'] = $this->type->value;
		if ($this->format) $this->data['format'] = $this->format->value;
		if ($this->per) $this->data['per'] = $this->per;
		if ($this->page) $this->data['page'] = $this->page;
		return $this->data;
	}
}