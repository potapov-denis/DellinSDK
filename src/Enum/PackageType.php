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
 * Справочник дополнительных услуг упаковки
 *
 * @see https://dev.dellin.ru/api/catalogs/directories/#_header10
 *
 */
enum PackageType: string implements Titlable
{

	/**
	 *
	 * Фикс! В Деловых линиях используются разные коды типов упаковки
	 *
	 * @see https://dev.dellin.ru/api/catalogs/directories/#_header28
	 *
	 */
	public const PACKAGES_AVAILABLE = [
		'0x838fc70baeb49b564426b45b1d216c15' => '0xA6A7BD2BF950E67F4B2CF7CC3A97C111',
		'0x8783b183e825d40d4eb5c21ef63fbbfb' => '0xB26E3AE60BF5FB6646363AFC69A10819',
		'0x951783203a254a05473c43733c20fe72' => '0x82750921BC8128924D74F982DD961379',
		'0x9a7f11408f4957d7494570820fcf4549' => '0xAE2EEA993230333043E719D4965D5D31',
		'0x9dd8901b0ecef10c11e8ed001199bf6e' => '0xad97901b0ecef0f211e889fcf4624fec',
		'0x9dd8901b0ecef10c11e8ed001199bf6f' => '0xad97901b0ecef0f211e889fcf4624fed',
		'0x9dd8901b0ecef10c11e8ed001199bf70' => '0xad97901b0ecef0f211e889fcf4624fea',
		'0xa8b42ac5ec921a4d43c0b702c3f1c109' => '0xB5FF5BC18E642C354556B93D7FBCDE2F',
		'0xad22189d098fb9b84eec0043196370d6' => '0x947845D9BDC69EFA49630D8C080C4FBE',
		'0xbaa65b894f477a964d70a4d97ec280be' => '0xA0A820F33B2F93FE44C8058B65C77D0F',
		'0x9dd8901b0ecef10c11e8ed001199bf71' => '0xad97901b0ecef0f211e889fcf4624feb',
		'0xb9f594d27a2d31b440a647d19547543c' => null


	];
	/* Деревянная обрешетка
			Несовместимо с Жесткий короб
	*/
	case CRATE = '0xA6A7BD2BF950E67F4B2CF7CC3A97C111';


	/* Жесткий короб
			Несовместимо с Деревянная обрешетка
	*/
	case CRATE_PLUS = '0xB26E3AE60BF5FB6646363AFC69A10819';


	/* Картонная коробка */
	case BOX = '0x82750921BC8128924D74F982DD961379';


	/* Дополнительная упаковка
			Несовместимо с:
			- 0x84f7578779ae4a444e3dfc8b96d80e08
	*/
	case TYPE = '0xAE2EEA993230333043E719D4965D5D31';


	/* Комплекс «обрешётка + амортизация
			Несовместимо с:
			- 0xb9f594d27a2d31b440a647d19547543c
	*/
	case CRATE_WITH_BUBBLE = '0xad97901b0ecef0f211e889fcf4624fec';


	/* Спец. упаковка для автостекол
			Несовместимо с Спец. упаковка для автозапчастей
	*/
	case PROTECT_AUTO_GLASS = '0xad97901b0ecef0f211e889fcf4624fed';


	/* Спец. упаковка для автозапчастей
			Несовместимо с Спец. упаковка для автостекол
	*/
	case PROTECT_AUTO_PART = '0xad97901b0ecef0f211e889fcf4624fea';


	/* Воздушно-пузырьковая плёнка
	*/
	case BUBBLE = '0xB5FF5BC18E642C354556B93D7FBCDE2F';

	/* Мешок
	*/
	case BAG = '0x947845D9BDC69EFA49630D8C080C4FBE';


	/* Паллетный борт (только до терминала-получателя)
			Несовместимо с :
			- 0x9195b45e731fd4bd44c3157f2e23b33f
	*/
	case PALLET = '0xA0A820F33B2F93FE44C8058B65C77D0F';

	/* Комплекс «палетный борт + амортизация»
			Несовместимо с :
			- 0x9195b45e731fd4bd44c3157f2e23b33f
	*/
	case PALLET_WITH_BUBBLE = '0xad97901b0ecef0f211e889fcf4624feb';


	public static function PackageTryFrom(string $value): PackageType|null
	{
		return self::TryFrom($value) ?: self::TryFrom(self::PACKAGES_AVAILABLE[$value]);
	}

	public static function getEnum(): string
	{
		return __CLASS__;
	}

	public function getIncompatibleDescription(): string
	{
		return match ($this) {
			self::CRATE => 'Упаковка "Деревянная обрешетка" несовместима с "Жесткий короб"',
			self::CRATE_PLUS => 'Упаковка "Жесткий короб" несовместима с "Деревянная обрешетка"',
			default => 'Несовместимые типы упаковки'
		};
	}

	public function getTitle(): string
	{
		return match ($this) {
			self::CRATE => 'Деревянная обрешетка',
			self::CRATE_PLUS => 'Жесткий короб',
			self::BOX => 'Картонная коробка',
			self::TYPE => 'Дополнительная упаковка',
			self::CRATE_WITH_BUBBLE => 'Комплекс обрешётка + амортизация',
			self::PROTECT_AUTO_GLASS => 'Спец. упаковка для автостекол',
			self::PROTECT_AUTO_PART => 'Спец. упаковка для автозапчастей',
			self::BUBBLE => 'Воздушно-пузырьковая плёнка',
			self::BAG => 'Мешок',
			self::PALLET => 'Паллетный борт',
			self::PALLET_WITH_BUBBLE => 'Комплекс паллетный борт + амортизация',
		};
	}
}

