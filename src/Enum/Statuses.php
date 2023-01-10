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
 * Статусы грузов
 *
 * @see https://dev.dellin.ru/api/catalogs/directories/#_header34
 */
enum Statuses: string
{
	/* Статус Черновик */
	case DRAFT = 'draft';

	/* Статус В обработке */
	case PROCESSING = 'processing';

	/* Статус Забор груза от адреса */
	case PICKUP = 'pickup';

	/* Статус Ожидает сдачи на терминал */
	case WAITING = 'waiting';

	/* Статус Отклонен */
	case DECLINED = 'declined';

	/* Статус Груз принят к перевозке */
	case RECEIVED = 'received';

	/* Статус Груз принят к перевозке. Платное хранение */
	case RECEIVED_WAREHOUSING = 'received_warehousing';

	/* Статус Груз в пути */
	case INWAY = 'inway';

	/* Статус Груз прибыл на терминал */
	case ARRIVED = 'arrived';

	/* Статус Груз прибыл на терминал. Платное хранение */
	case WAREHOUSING = 'warehousing';

	/* Статус Груз прибыл в аэропорт */
	case ARRIVED_TO_AIRPORT = 'arrived_to_airport';

	/* Статус Груз прибыл в аэропорт. Платное хранение */
	case AIRPORT_WAREHOUSING = 'airport_warehousing';

	/* Статус Доставка груза до адреса */
	case DELIVERY = 'delivery';

	/* Статус Груз выдан. Возврат СД */
	case ACCOMPANYING_DOCUMENTS_RETURN = 'accompanying_documents_return';

	/* Статус Заказ завершен */
	case FINISHED = 'finished';

	public static function getEnum(): string
	{
		return __CLASS__;
	}

	public function getTitle(): string
	{
		return match ($this) {
			self::DRAFT => 'Черновик',
			self::PROCESSING => 'В обработке',
			self::PICKUP => 'Забор груза от адреса',
			self::WAITING => 'Ожидает сдачи на терминал',
			self::DECLINED => 'Отклонен',
			self::RECEIVED => 'Груз принят к перевозке',
			self::RECEIVED_WAREHOUSING => 'Груз принят к перевозке. Платное хранение',
			self::INWAY => 'Груз в пути',
			self::ARRIVED => 'Груз прибыл на терминал',
			self::WAREHOUSING => 'Груз прибыл на терминал. Платное хранение',
			self::ARRIVED_TO_AIRPORT => 'Груз прибыл в аэропорт',
			self::AIRPORT_WAREHOUSING => 'Груз прибыл в аэропорт. Платное хранение',
			self::DELIVERY => 'Доставка груза до адреса',
			self::ACCOMPANYING_DOCUMENTS_RETURN => 'Груз выдан. Возврат СД',
			self::FINISHED => 'Заказ завершен'
		};
	}
}
