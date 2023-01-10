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

use Yooogi\DellinSDK\Endpoints\Marking\Entities\HandlingMark;
use Yooogi\DellinSDK\Enum\ShippingLabelType;
use function func_get_args;

final class GetHandlingMarksRequest extends GetMarksRequest
{

	private bool $oneFile = false;
	private ?ShippingLabelType $type = null;
	private array $handlingMarks;

	/**
	 * Запрос получение этикеток с манипуляционными знаками
	 *
	 * @param HandlingMark[] $handlingMarks
	 *
	 */
	public function __construct(array $handlingMarks, bool $oneFile = false, ?ShippingLabelType $type = null)
	{
		parent::__construct($handlingMarks, $oneFile, $type);
	}

	/**
	 * Запрос получение этикеток с манипуляционными знаками
	 *
	 * @param HandlingMark[] $handlingMarks
	 *
	 * @return GetHandlingMarksRequest
	 */
	public static function create(array $handlingMarks, bool $oneFile = false, ?ShippingLabelType $type = null): GetHandlingMarksRequest
	{
		return new GetHandlingMarksRequest(...func_get_args());
	}

	public function toArray(): array
	{
		parent::toArray();
		$this->data['handlingMarks'] = array_map(static function ($handlingMark) {
			return $handlingMark->toArray();
		}, $this->marks);

		return $this->data;
	}
}