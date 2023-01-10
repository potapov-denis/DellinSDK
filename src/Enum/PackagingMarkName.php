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
 * pallet Палетный борт - ПБ
 * crate - Деревянная обрешётка - ЖУ
 * crate_plus - Жёсткий короб - ЖК
 * box - Картонная коробка - КК
 * bag - Мешок - Мешок
 * bubble - Воздушно-пузырьковая плёнка - ВПП
 * tape - Дополнительная упаковка - ДОП
 * pallet_with_bubble - Палетный борт и амортизация - СПЕЦ ПБ
 * crate_with_bubble - Деревянная обрешетка и амортизация - СПЕЦ ЖУ
 * protect_auto_part - Специальная упаковка для автозапчастей - СПЕЦ БАМПЕР
 * protect_auto_glass - Специальная упаковка для автостекол - СПЕЦ АВТОСТЕКЛО
 *
 * @see https://dev.dellin.ru/api/marking/packaging/
 */
enum PackagingMarkName: string implements Markable
{

	case PALLET = 'pallet';
	case CRATE = 'crate';
	case CRATE_PLUS = 'crate_plus';
	case BOX = 'box';
	case BAG = 'bag';
	case BUBBLE = 'bubble';
	case TAPE = 'tape';
	case PALLET_WITH_BUBBLE = 'pallet_with_bubble';
	case CRATE_WITH_BUBBLE = 'crate_with_bubble';
	case PROTECT_AUTO_PART = 'protect_auto_part';
	case PROTECT_AUTO_GLASS = 'protect_auto_glass';

	public static function getEnum(): string
	{
		return __CLASS__;
	}

	public function getTitle(): string
	{
		return match ($this) {
			self::PALLET => 'Палетный борт',
			self::CRATE => 'Деревянная обрешётка',
			self::CRATE_PLUS => 'Жёсткий короб',
			self::BOX => 'Картонная коробка',
			self::BAG => 'Мешок',
			self::BUBBLE => 'Воздушно-пузырьковая плёнка',
			self::TAPE => 'Дополнительная упаковка',
			self::PALLET_WITH_BUBBLE => 'Палетный борт и амортизация',
			self::CRATE_WITH_BUBBLE => 'Деревянная обрешетка и амортизация',
			self::PROTECT_AUTO_PART => 'Специальная упаковка для автозапчастей',
			self::PROTECT_AUTO_GLASS => 'Специальная упаковка для автостекол'

		};
	}

}
