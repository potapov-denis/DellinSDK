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
 * Справочник специальных требований к транспорту
 *
 * @see https://dev.dellin.ru/api/catalogs/directories/#_header22
 *
 */
enum TransportRequirements: string implements Titlable
{
	/* Для погрузки необходим гидроборт
			Несовместимо с Манипулятор:
			- 0x88f93a2c37f106d94ff9f7ada8efe886
		*/
	case HYDROBORT = '0x92fce2284f000b0241dad7c2e88b1655';


	/* Для погрузки необходим манипулятор
			Несовместимо с Гидроборт:
			- 0x92fce2284f000b0241dad7c2e88b1655
	 */
	case MANIPULATOR = '0x88f93a2c37f106d94ff9f7ada8efe886';


	/* Для погрузки необходима открытая машина
			Несовместимо с Растентовка
			-0x818e8ff1eda1abc349318a478659af08
	*/
	case OPENCAR = '0x9951e0ff97188f6b4b1b153dfde3cfec';


	/* Растентовка
			Несовместимо с Открытая машина
			-0x9951e0ff97188f6b4b1b153dfde3cfec
	*/
	case UNCOVER = '0x818e8ff1eda1abc349318a478659af08';


	public static function getEnum()
	{
		return static::class;
	}

	public function getTitle()
	{
		return match ($this) {
			self::HYDROBORT => 'Гидроборт',
			self::MANIPULATOR => 'Манипулятор',
			self::OPENCAR => 'Открытая машина',
			self::UNCOVER => 'Растентовка',
		};
	}

	public function getIncompatibleDescription(): string
	{
		return match ($this) {
			self::HYDROBORT => 'Услуга "Гидроборт" несовместима с "Манипулятор"',
			self::MANIPULATOR => 'Упаковка "Манипулятор" несовместима с "Гидроборт"',
			self::OPENCAR => 'Упаковка "Открытая машина" несовместима с "Растентовка"',
			self::UNCOVER => 'Упаковка "Растентовка" несовместима с "Открытая машина"',
		};
	}

}
