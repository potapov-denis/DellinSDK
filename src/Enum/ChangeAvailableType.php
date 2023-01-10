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
 * Возможные изменения заказа
 *
 * 'receiver' - Изменение получателя по заказу;
 * 'suspend' - Приостановка выдачи груза;
 * 'resume' - Возобновление выдачи груза
 * 'payer' - Изменение плательщика по заказу
 * 'pickupInfo' - Изменение информации об адресе и времени забора
 * 'deliveryInfo' - Изменение информации об адресе и времени доставки
 * 'cancelPickup' - Отмена забора груза от адреса
 * 'cancelDelivery' - Отмена доставки груза до адреса
 * 'changeSender' - Изменение контактной информации об отправителе
 * 'changeReceiver' - Изменение контактной информации о получателе
 *
 * @see https://dev.dellin.ru/api/order/check/
 */
enum ChangeAvailableType: string implements Titlable
{
	/* Изменение получателя по заказу */
	case RECEIVER = 'receiver';

	/* Приостановка выдачи груза*/
	case SUSPEND = 'suspend';

	/* Возобновление выдачи груза */
	case RESUME = 'resume';

	/* Изменение плательщика по заказу */
	case PAYER = 'payer';

	/* Изменение информации об адресе и времени забора */
	case PICKUP_INFO = 'pickupInfo';

	/* Изменение информации об адресе и времени доставки */
	case DELIVERY_INFO = 'deliveryInfo';

	/* Отмена забора груза от адреса */
	case CANCEL_PICKUP = 'cancelPickup';

	/* Отмена доставки груза до адреса */
	case CANCEL_DELIVERY = 'cancelDelivery';

	/* Изменение контактной информации об отправителе */
	case CHANGE_SENDER = 'changeSender';

	/* Изменение контактной информации о получателе */
	case CHANGE_RECEIVER = 'changeReceiver';

	public function getTitle(): string
	{
		return match ($this) {
			self::RECEIVER => 'Изменение получателя по заказу',
			self::SUSPEND => 'Приостановка выдачи груза',
			self::RESUME => 'Возобновление выдачи груза',
			self::PAYER => 'Изменение плательщика по заказу',
			self::PICKUP_INFO => 'Изменение информации об адресе и времени забора',
			self::DELIVERY_INFO => 'Изменение информации об адресе и времени доставки',
			self::CANCEL_PICKUP => 'Отмена забора груза от адреса',
			self::CANCEL_DELIVERY => 'Отмена доставки груза до адреса',
			self::CHANGE_SENDER => 'Изменение контактной информации об отправителе',
			self::CHANGE_RECEIVER => 'Изменение контактной информации о получателе'

		};
	}
}
