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
 * Дополнительный статус заказа на английском языке.
 *
 * Возможные значения (порядок соответствует порядку возможных значений параметра 'detailedStatusRus'):
 *
 * 'pickup_waiting_pickup' - 'Ожидается забор' - водитель ещё не выехал на адрес отправителя;
 * 'pickup_departed' - 'Машина едет на адрес';
 * 'pickup_arrived' - 'Машина на адресе';
 * 'pickup_arrived_at_first' - 'Прибыл на первый адрес';
 * 'pickup_arrived_at_last' - 'Прибыл на последний адрес';
 * 'pickup_finished' - 'Груз забран. Едет на терминал';
 * 'delivery_waiting_delivery' - 'Ожидается доставка' - водитель ещё не выехал на адрес получателя;
 * 'delivery_departed' - 'Машина едет на адрес';
 * 'delivery_arrived' - 'Машина на адресе';
 * 'delivery_finished' - 'Груз доставлен';
 *
 * @see https://dev.dellin.ru/api/orders/search/#_header8
 */
enum DetailedStatus: string
{

	case PICKUP_WAITING_PICKUP = 'pickup_waiting_pickup';
	case PICKUP_DEPARTED = 'pickup_departed';
	case PICKUP_ARRIVED = 'pickup_arrived';
	case PICKUP_ARRIVED_AT_FIRST = 'pickup_arrived_at_first';
	case PICKUP_ARRIVED_AT_LAST = 'pickup_arrived_at_last';
	case PICKUP_FINISHED = 'pickup_finished';
	case DELIVERY_WAITING_DELIVERY = 'delivery_waiting_delivery';
	case DELIVERY_DEPARTED = 'delivery_departed';
	case DELIVERY_ARRIVED = 'delivery_arrived';
	case DELIVERY_FINISHED = 'delivery_finished';

	public function getTitle(): string
	{
		return match ($this) {
			self::PICKUP_WAITING_PICKUP => 'Ожидается забор',
			self::PICKUP_DEPARTED => 'Машина едет на адрес',
			self::PICKUP_ARRIVED => 'Машина на адресе',
			self::PICKUP_ARRIVED_AT_FIRST => 'Прибыл на первый адрес',
			self::PICKUP_ARRIVED_AT_LAST => 'Прибыл на последний адрес',
			self::PICKUP_FINISHED => 'Груз забран. Едет на терминал',
			self::DELIVERY_WAITING_DELIVERY => 'Ожидается доставка',
			self::DELIVERY_DEPARTED => 'Машина едет на адрес',
			self::DELIVERY_ARRIVED => 'Машина на адресе"',
			self::DELIVERY_FINISHED => 'Груз доставлен',
		};

	}

}

