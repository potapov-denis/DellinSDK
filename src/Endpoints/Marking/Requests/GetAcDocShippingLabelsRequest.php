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

use function func_get_args;

final class GetAcDocShippingLabelsRequest extends ShippingLabelsRequest
{

	/**
	 * Запрос на получение этикеток на сопроводительные документы
	 *
	 * @param string $orderID
	 */
	public function __construct(string $orderID)
	{
		parent::__construct($orderID);
	}

	/**
	 * Запрос на получение этикеток на сопроводительные документы
	 *
	 * @param string $orderID
	 *
	 * @return GetAcDocShippingLabelsRequest
	 */
	public static function create(string $orderID): GetAcDocShippingLabelsRequest
	{
		return new GetAcDocShippingLabelsRequest(...func_get_args());
	}
}