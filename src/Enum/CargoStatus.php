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
 * Статус грузового места.
 *
 * Возможные значения:
 *
 * new - ожидает приемки, грузовое место имеет данный статус с момента отправки информации о грузовых местах до момента их обработки на терминале;
 * accepted - принято на терминале;
 * not_accepted - не принято;
 * unindentified - не опознано; статус устанавливается, если грузовое место не было промаркировано;
 * no_info - нет информации
 *
 * @see https://dev.dellin.ru/api/marking/labels/#_header32
 */
enum CargoStatus: string
{
	/* Статус ожидает приемки */
	case NEW = 'new';

	/* Статус принято на терминале */
	case ACCEPTED = 'accepted';

	/* Статус не принято */
	case NOT_ACCEPTED = 'not_accepted';

	/* Статус не опознано */
	case UNINDENTIFIED = 'unindentified';

	/* Статус нет информации */
	case NO_INFO = 'no_info';

	public static function getEnum(): string
	{
		return __CLASS__;
	}

	public function getTitle(): string
	{
		return match ($this) {
			self::NEW => 'Ожидает приемки',
			self::ACCEPTED => 'Принято на терминале',
			self::NOT_ACCEPTED => 'Не принято',
			self::UNINDENTIFIED => 'Не опознано',
			self::NO_INFO => 'Нет информации'
		};
	}
}
