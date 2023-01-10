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

use Yooogi\DellinSDK\Core\Enum;

/**
 * Список дополнительных услуг (предоставление которых может быть ограничено из-за условий заказа) по которым необходима информация.
 *
 *  Доступные значения:
 *
 * 'day_to_day' - возможность передать груз водителю-экспедитору на адресе отправителя в день заказа;
 * 'packages' - доступные упаковки (аналогично методу 'Доступные упаковки');
 * 'loadings' - доступные виды погрузки/дополнительные опции при погрузке;
 * 'insurance' - услуга 'Страхование срока доставки'
 *
 * @see https://dev.dellin.ru/api/catalogs/request-conditions/#_header4
 *
 */
enum BlockType: string
{
	/* Возможность передать груз водителю-экспедитору на адресе отправителя в день заказа */
	case DAY_TO_DAY = 'day_to_day';
	/* Доступные упаковки (аналогично методу 'Доступные упаковки') */
	case PACKAGES = 'packages';
	/* Доступные виды погрузки/дополнительные опции при погрузке */
	case LOADINGS = 'loadings';
	/* Услуга 'Страхование срока доставки' */
	case INSURANCE = 'insurance';

	public function getTitle(): string
	{

		return match ($this) {
			self::DAY_TO_DAY => 'Возможность передать груз водителю-экспедитору на адресе отправителя в день заказа',
			self::PACKAGES => 'Доступные упаковки',
			self::LOADINGS => 'Доступные виды погрузки/дополнительные опции при погрузке',
			self::INSURANCE => 'Страхование срока доставки'
		};

	}
}


