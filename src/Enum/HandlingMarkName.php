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

use Yooogi\DellinSDK\Core\Markable;

/**
 * Идентификатор манипуляционного знака.
 *
 * Возможные значения:
 *
 * fragile_cargo - 'хрупкий груз';
 * this_way_up - 'верх';
 * stack_forbidden - 'штабелирование запрещено';
 * beacon - 'радиоизлучение'
 *
 * @see https://dev.dellin.ru/api/marking/marks/#_header2
 */
enum HandlingMarkName: string implements Markable
{

	case FRAGILE_CARGO = 'fragile_cargo';
	case THIS_WAY_UP = 'this_way_up';
	case STACK_FORBIDDEN = 'stack_forbidden';
	case BEACON = 'beacon';

	public static function getEnum(): string
	{
		return __CLASS__;
	}

	public function getTitle(): string
	{
		return match ($this) {
			self::FRAGILE_CARGO => 'Хрупкий груз',
			self::THIS_WAY_UP => 'Верх',
			self::STACK_FORBIDDEN => 'Штабелирование запрещено',
			self::BEACON => 'Радиоизлучение'
		};
	}

}
