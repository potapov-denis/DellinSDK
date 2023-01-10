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

use Yooogi\DellinSDK\Endpoints\Calculations\Exceptions\CompatibleException;
use Yooogi\DellinSDK\Enum\LoadType;
use Yooogi\DellinSDK\Enum\TransportRequirements;
use function func_get_args;

class RequirementsCollection extends Collection
{

	/**
	 * Несовместимые типы погрузки
	 *
	 * @var array|string[][]
	 */
	protected array $incompatible = [
		'0x92fce2284f000b0241dad7c2e88b1655' => ['0x88f93a2c37f106d94ff9f7ada8efe886'],
		'0x88f93a2c37f106d94ff9f7ada8efe886' => ['0x92fce2284f000b0241dad7c2e88b1655'],
		'0x9951e0ff97188f6b4b1b153dfde3cfec' => ['0x818e8ff1eda1abc349318a478659af08'],
		'0x818e8ff1eda1abc349318a478659af08' => ['0x9951e0ff97188f6b4b1b153dfde3cfec'],
	];

	/**
	 * Массив типов погрузки
	 *
	 * @param TransportRequirements[]|LoadType[] $types
	 */

	public function __construct(array $types = [], int $flags = 0, string $iteratorClass = 'ArrayIterator')
	{
		if ($this->validate($types)) {
			parent::__construct($types, $flags, $iteratorClass);
		} else {
			$message = $this->getExceptionMessage();
			throw new CompatibleException();
		}

	}

	/**
	 * Массив типов погрузки
	 *
	 * @param TransportRequirements[]|LoadType[] $types
	 */


	public static function create(array $types = [], int $flags = 0, string $iteratorClass = 'ArrayIterator'): self
	{
		return new self(...func_get_args());

	}
}
