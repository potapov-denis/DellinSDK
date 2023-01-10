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
 * Справочник видов загрузки
 *
 * @see https://dev.dellin.ru/api/catalogs/directories/#_header17
 *
 */
enum LoadType: string implements Titlable
{
	/* Боковая загрузка */
	case SIDELOAD = '0xb83b7589658a3851440a853325d1bf69';
	/* Верхняя загрузка */
	case TOPLOAD = '0xabb9c63c596b08f94c3664c930e77778';


	public static function getEnum()
	{
		return static::class;
	}

	public function getTitle()
	{
		return match ($this) {
			self::SIDELOAD => 'Боковая загрузка',
			self::TOPLOAD => 'Верхняя загрузка',

		};
	}

}


