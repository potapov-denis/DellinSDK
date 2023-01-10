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

namespace Yooogi\DellinSDK\Enum;

/**
 * Тип формы документа
 *
 * @see https://dev.dellin.ru/api/orders/print/#_header5
 */
enum PrintModeType: string
{
	/* Счёт */
	case BILL = 'bill';

	/* Накладная */
	case ORDER = 'order';

	/* Счёт-фактура */
	case INVOICE = 'invoice';

	/* Накладная на выдачу */
	case GIVEOUT = 'giveout';

	public static function getEnum()
	{
		return static::class;
	}

	public function getTitle(): string
	{
		return match ($this) {
			self::BILL => 'Счёт',
			self::ORDER => 'Накладная',
			self::INVOICE => 'Счёт-фактура',
			self::GIVEOUT => 'Накладная на выдачу',
		};
	}
}
