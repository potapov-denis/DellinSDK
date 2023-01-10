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

use Yooogi\DellinSDK\Entities\DerivalArrival;
use Yooogi\DellinSDK\Enum\DeliveryType;

/**
 * Запрос интервалов передачи груза на адресе отправителя
 *
 * @see https://dev.dellin.ru/api/catalogs/time-interva/#_header2
 */
final class DispatchTimeRequest extends DispatchRequest
{
	/**
	 * Запрос интервалов передачи груза на адресе отправителя
	 *
	 * @param DeliveryType $deliveryType
	 * @param DerivalArrival $derival
	 *
	 * @see https://dev.dellin.ru/api/catalogs/time-interva/#_header2
	 */
	public static function create(DeliveryType $deliveryType, DerivalArrival $derival): DispatchTimeRequest
	{
		return new DispatchTimeRequest(...\func_get_args());
	}
}
