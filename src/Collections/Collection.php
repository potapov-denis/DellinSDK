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


use ArrayObject;
use Exception;
use UnitEnum;

class Collection extends ArrayObject
{
	protected array $values = [];
	protected $enum;
	protected array $incompatible = [];

	public function __construct(object|array $values = [], int $flags = 0, string $iteratorClass = 'ArrayIterator')
	{
		if (is_object($values)) {
			parent::__construct($this->add($values), $flags, $iteratorClass);
		} else {
			parent::__construct($values, $flags, $iteratorClass);
		}

	}

	protected function add($items): array
	{
		$this->values[] = $items;
		return $this->values;
	}

	public function __call($func, $argv)
	{
		if (!is_callable($func) || substr($func, 0, 6) !== 'array_') {
			throw new Exception(__CLASS__ . '->' . $func);
		}
		return call_user_func_array($func, array_merge([$this->getArrayCopy()], $argv));
	}

	protected function validate($items)
	{
		$items = $this->toArray($items);

		foreach ($items as $item) {

			if (array_key_exists($item, $this->incompatible)) {
				if (count(array_uintersect($items, $this->incompatible[$item], function ($a, $b) {
						return $a <=> $b;
					}
					)) > 0) {
					$this->incompatibleValue = $item;
					return false;
				}
			}
		}
		return true;
	}

	protected function toArray($items): array
	{
		foreach ($items as $item) {
			if ($item instanceof UnitEnum) {
				$this->values[] = $item->value;
				$this->enum = $item::getEnum();
			}
		}
		return $this->values;
	}

	protected function getExceptionMessage()
	{
		if ($this->enum::tryFrom($this->incompatibleValue) !== null) {
			return $this->enum::tryFrom($this->incompatibleValue)->getIncompatibleDescription();
		}
	}

}
