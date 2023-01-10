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
 * Вид транспортировки.
 *
 * @see https://dev.dellin.ru/api/calculation/calculator/#_header8
 *
 * - ADDRESS - доставка груза непосредственно от адреса отправителя/до адреса получателя. Примечание. При заказе перевозки малогабаритного груза (значение параметра запроса
 * 'delivery.deliverуType.type' - 'small') доставка от/до терминала невозможна;
 * - TERMINAL - доставка груза от/до терминала;
 * - AIRPORT  - Наземный доставка груза до аэропорта, вариант используется, если в городе, в который необходимо доставить груз, нет терминала 'Деловых Линий', в этом случае груз
 * можно получить в грузовом терминале в аэропорту.
 * Примечание. Вариант используется только для объекта 'request.delivery.arrival' и только при заказе авиаперевозки
 */
enum TransportType: string
{
	/** Авиа */
	case ADDRESS = 'address';
	/** Системой ускоренной почты */
	case TERMINAL = 'terminal';
	/** Наземный */
	case AIRPORT = 'airport';
}
