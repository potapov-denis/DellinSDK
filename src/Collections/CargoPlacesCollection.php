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

namespace Yooogi\DellinSDK\Collections;

use Yooogi\DellinSDK\Entities\CargoPlace;
use function func_get_args;

class CargoPlacesCollection extends Collection
{

	/**
	 * @param array<int, CargoPlace>|CargoPlace $items
	 */
	public function __construct(array $items = [], int $flags = 0, string $iteratorClass = 'ArrayIterator')
	{
		parent::__construct($items, $flags, $iteratorClass);
	}

	/**
	 * @param CargoPlace $item
	 */
	public static function one(object $item, int $flags = 0, string $iteratorClass = 'ArrayIterator'): self
	{

		return new self([$item]);

	}

	/**
	 * @param array<int, CargoPlace> $items
	 */
	public static function create(array $items = [], int $flags = 0, string $iteratorClass = 'ArrayIterator'): self
	{

		return new self(...func_get_args());

	}
}
