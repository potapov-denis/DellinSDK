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
 * Тип изменённой информации.
 *
 * @see https://dev.dellin.ru/api/orders/history/#_header11
 */
enum TypeCode: string
{
	/* Изменение получателя */
	case RECEIVER_CHANGE = 'receiver_change';

	/* Изменение плательщика */
	case PAYER_CHANGE = 'payer_change';

	/* Разрешить выдачу груза по платежному поручению */
	case PAYMENT_ORDER_CHANGE = 'payment_order_change';

	/* Изменение контактной информации */
	case CONTACT_INFO_CHANGE = 'contact_info_change';

	/* Приостановка выдачи груза */
	case GIVEOUT_SUSPENSION_CHANGE = 'giveout_suspension_change';

	/* 	Возобновление выдачи груза */
	case GIVEOUT_RESUMPTION_CHANGE = 'giveout_resumption_change';

	/* Отмена доставки до адреса */
	case DELIVERY_CANCEL_CHANGE = 'delivery_cancel_change';

	/* Отмена доставки от адреса */
	case PICKUP_CANCEL_CHANGE = 'pickup_cancel_change';

	/* 	Смена адреса и времени доставки до адреса */
	case DELIVERY_INFO_CHANGE = 'delivery_info_change';

	/* Смена адреса и времени доставки от адреса */
	case PICKUP_INFO_CHANGE = 'pickup_info_change';

	public function getTitle(): string
	{
		return match ($this) {
			self::RECEIVER_CHANGE => 'Изменение получателя',
			self::PAYER_CHANGE => 'Изменение плательщика',
			self::PAYMENT_ORDER_CHANGE => 'Разрешить выдачу груза по платежному поручению',
			self::CONTACT_INFO_CHANGE => 'Изменение контактной информации',
			self::GIVEOUT_SUSPENSION_CHANGE => 'Приостановка выдачи груза',
			self::GIVEOUT_RESUMPTION_CHANGE => 'Возобновление выдачи груза',
			self::DELIVERY_CANCEL_CHANGE => 'Отмена доставки до адреса',
			self::PICKUP_CANCEL_CHANGE => 'Отмена доставки от адреса',
			self::DELIVERY_INFO_CHANGE => 'Смена адреса и времени доставки до адреса',
			self::PICKUP_INFO_CHANGE => 'Смена адреса и времени доставки от адреса'
		};
	}
}
