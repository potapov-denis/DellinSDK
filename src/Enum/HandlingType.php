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

use Yooogi\DellinSDK\Core\Titlable;

/**
 * Справочник услуг ПРР
 *
 * @see https://dev.dellin.ru/api/catalogs/directories/#_header12
 *
 */
enum HandlingType: string implements Titlable
{
	/* Грузовой лифт */
	case FREIGHT_LIFT = '0xa77fcf6a449164ed490133777a68bd51';
	/* Номер этажа, на который необходимо поднять груз */
	case TO_FLOOR = '0xadf1fc002cb8a9954298677b22dbde12';
	/* Расстояние, на которое необходимо перенести груз */
	case CARRY = '0x9a0d647ddb11ebbd4ddaaf3b1d9f7b74';


	/**
	 * @param $key
	 *
	 * @return HandlingType
	 */
	public static function tryFromKey($key): HandlingType
	{
		return match ($key) {
			'freightLift' => self::FREIGHT_LIFT,
			'carry' => self::TO_FLOOR,
			'toFloor' => self::CARRY

		};
	}

	/**
	 * @return string
	 */
	public static function getEnum()
	{
		return static::class;
	}

	/**
	 * @return string
	 */
	public function getTitle(): string
	{
		return match ($this) {
			self::FREIGHT_LIFT => 'Грузовой лифт',
			self::TO_FLOOR => 'Поднятие на этаж',
			self::CARRY => 'Пронос'

		};
	}

}


