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
use Yooogi\DellinSDK\Endpoints\Calculations\Entities\NormalizedDerivalArrival;
use Yooogi\DellinSDK\Enum\AddressType;
use Yooogi\DellinSDK\Enum\Country;
use function func_get_args;

final class Address implements Arrayable
{
	use DataAware;

	private AddressType $type;
	private ?string $search = null;
	private ?string $street = null;
	private ?string $house = null;
	private ?string $building = null;
	private ?string $structure = null;
	private ?string $flat = null;

	public function __construct(AddressType $type = AddressType::SEARCH, ?string $value = null)
	{
		$this->setType($type, $value);

	}

	public function setType(AddressType $type, string $value): Address
	{
		switch ($type) {
			case AddressType::SEARCH :
				$this->search = ($value) ? mb_strimwidth($value, 0, 1024, '', 'UTF8')
					: null;
				break;
			case AddressType::STREET :
				$this->street = $value;
				break;
		}
		return $this;
	}

	public static function create(AddressType $type, ?string $value): self
	{
		return new self(...func_get_args());
	}

	/**
	 * @return string|null
	 */
	public function getStreet(): ?string
	{
		return $this->street;
	}

	/**
	 * @param string|null $street
	 */
	public function setStreet(?string $street): Address
	{
		$this->street = $street;
		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getHouse(): ?string
	{
		return $this->house;
	}

	/**
	 * @param string|null $house
	 */
	public function setHouse(?string $house): Address
	{
		$this->house = $house;
		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getBuilding(): ?string
	{
		return $this->building;
	}

	/**
	 * @param string|null $building
	 */
	public function setBuilding(?string $building): Address
	{
		$this->building = $building;
		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getStructure(): ?string
	{
		return $this->structure;
	}

	/**
	 * @param string|null $structure
	 */
	public function setStructure(?string $structure): Address
	{
		$this->structure = $structure;
		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getFlat(): ?string
	{
		return $this->flat;
	}

	/**
	 * @param string|null $flat
	 */
	public function setFlat(?string $flat): Address
	{
		$this->flat = $flat;
		return $this;
	}

	public function toArray(): array
	{

		if ($this->search) $this->data['search'] = $this->search;
		if ($this->street) $this->data['street'] = $this->street;
		if ($this->house) $this->data['house'] = $this->house;
		if ($this->building) $this->data['building'] = $this->building;
		if ($this->structure) $this->data['structure'] = $this->structure;
		if ($this->flat) $this->data['flat'] = $this->flat;
		return $this->data;
	}

}
