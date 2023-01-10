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
 * Справочник специальных требований к транспорту
 *
 * - AUTO - автодоставка;
 * - EXPRESS - экспресс-доставка;
 * - LETTER - письмо;
 * - AVIA - авиадоставка;
 * - SMALL - доставка малогабаритного груза.
 *
 *
 * Малогабаритный груз - это груз, параметры которого не превышают следующие значения:
 * масса меньше либо равна 30 кг;
 * Д*Ш*В меньше либо равны 0,54*0,39*0,39 м;
 * объём меньше либо равен 0,1 куб. м.
 * Заказ услуги 'Доставка малогабаритного груза' возможен только в случае, если в городах отправки и получения есть подразделения компании 'Деловые Линии', более подробную информацию см. на сайте компании
 *
 * @see https://dev.dellin.ru/api/calculation/calculator/
 *
 */
enum DeliveryType: string
{
	/* Автодоставка */
	case AUTO = 'auto';
	/* Экспресс-доставка */
	case EXPRESS = 'express';
	/* Письмо */
	case LETTER = 'letter';
	/* Авиадоставка */
	case AVIA = 'avia';
	/* Доставка малогабаритного груза. */
	case SMALL = 'small';

	const DELIVERY_TYPES = [
		'intercity' => 'auto',
		'air' => 'avia',
		'express' => 'express',
		'small' => 'small',
		'letter' => 'letter'
	];

	public const OVERSIZE_AVIA_WEIGHT = 80;
	public const OVERSIZE_AVIA_HEIGHT = 0.8;
	public const OVERSIZE_AVIA_WIDTH = 1;
	public const OVERSIZE_AVIA_LENGTH = 1.3;


	public const OVERSIZE_AUTO_WEIGHT = 100;
	public const OVERSIZE_AUTO_HEIGHT = 3;
	public const OVERSIZE_AUTO_WIDTH = 3;
	public const OVERSIZE_AUTO_LENGTH = 3;


	public function getUid(): string
	{
		return match ($this) {
			self::AUTO => '0xA8E38733915FD9844F1CD8DE0A9BEB4E',
			self::EXPRESS => '0x9AF6219358C3D0214D1714B9CF063259',
			self::LETTER => '0xABE8F6204DDB074441425AC36471E421',
			self::AVIA => '0x91C2110CC6B6430D4B1E2D59855A0E42',
			self::SMALL => '0x95ECD458FC6439B14A92AB8206807C40',

		};
	}

	public function getOversizedDimensions()
	{
		return match ($this) {
			self::AVIA => ['weight' => self::OVERSIZE_AVIA_WEIGHT,
				'height' => self::OVERSIZE_AVIA_HEIGHT,
				'width' => self::OVERSIZE_AVIA_WIDTH,
				'length' => self::OVERSIZE_AVIA_LENGTH],
			self::AUTO => ['weight' => self::OVERSIZE_AUTO_WEIGHT,
				'height' => self::OVERSIZE_AUTO_HEIGHT,
				'width' => self::OVERSIZE_AUTO_WIDTH,
				'length' => self::OVERSIZE_AUTO_LENGTH]

		};
	}

	public function getId(): string
	{
		return match ($this) {
			self::AUTO => '1',
			self::EXPRESS => '4',
			self::LETTER => '20',
			self::AVIA => '6',
			self::SMALL => '21',

		};
	}

	public function getTitle()
	{
		return match ($this) {
			self::AUTO => 'Авто',
			self::EXPRESS => 'Экспресс',
			self::LETTER => 'Письмо',
			self::AVIA => 'Авиа',
			self::SMALL => 'Малогабарит'
		};
	}

}
