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


namespace Yooogi\DellinSDK\Endpoints\Marking\Entities;

use Yooogi\DellinSDK\Enum\PackagingMarkName;
use Yooogi\DellinSDK\Enum\ShippingLabelFormat;

final class PackagingMark extends MarkEntity
{

	private PackagingMarkName $name;
	private int $count;
	private ?ShippingLabelFormat $format;

	/**
	 * Параметры массива этикеток для упаковки
	 *
	 * @param PackagingMarkName $name
	 * @param int $count
	 * @param ?ShippingLabelFormat $format
	 *
	 * @see https://dev.dellin.ru/api/marking/packaging/#_header13
	 *
	 */
	public function __construct(PackagingMarkName $name, int $count, ?ShippingLabelFormat $format = ShippingLabelFormat::SMALL)
	{
		parent::__construct($name, $count, $format);
	}

	/**
	 * Параметры массива этикеток для упаковки
	 *
	 * @param PackagingMarkName $name
	 * @param int $count
	 * @param ?ShippingLabelFormat $format
	 *
	 * @return PackagingMark
	 *
	 * @see https://dev.dellin.ru/api/marking/packaging/#_header13
	 */
	public static function create(PackagingMarkName $name, int $count, ?ShippingLabelFormat $format = ShippingLabelFormat::SMALL): PackagingMark
	{
		return new PackagingMark(...func_get_args());
	}

}