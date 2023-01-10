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
 * Статус документа
 *
 * У заявки на доставку от адреса отправителя/до адреса получателя/на междугороднюю перевозку выделенной еврофурой (значение параметра 'response.orders.documents.type' - 'request'/'request_sf'/'request_ftl') могут быть следующие статусы:
 *
 * 'temporary' - заявка не заполнена;
 * 'saved' - черновик;
 * 'ordered' - заявка в очереди на обработку;
 * 'loaded' - заявка взята на обработку;
 * 'processed' - заявка обработана;
 * 'declined' - заявка отклонена;
 * 'accepted' - заявка принята;
 * 'canceled' - заявка отменена.
 * У документа типа 'Накладная' (значение параметра 'response.orders.documents.type' - 'shipping') могут быть следующие статусы:
 *
 * 'in_way' - груз в пути;
 * 'arrival' - груз прибыл;
 * 'give_out' - груз выдан
 *
 * @see https://dev.dellin.ru/api/orders/search/#_header16
 */
enum OrderDocumentStateType: string
{
	case TEMPORARY = 'temporary';
	case SAVED = 'saved';
	case ORDERED = 'ordered';
	case LOADED = 'loaded';
	case PROCESSED = 'processed';
	case DECLINED = 'declined';
	case ACCEPTED = 'accepted';
	case CANCELED = 'canceled';
	case IN_WAY = 'in_way';
	case ARRIVAL = 'arrival';
	case GIVE_OUT = 'give_out';

	public static function getEnum()
	{
		return static::class;
	}

	public function getTitle(): string
	{

		return match ($this) {
			self::TEMPORARY => 'Заявка не заполнена',
			self::SAVED => 'Черновик',
			self::ORDERED => 'Заявка в очереди на обработку',
			self::LOADED => 'Заявка взята на обработку',
			self::PROCESSED => 'Заявка обработана',
			self::DECLINED => 'Заявка отклонена',
			self::ACCEPTED => 'Заявка принята',
			self::CANCELED => 'Заявка отменена',
			self::IN_WAY => 'Груз в пути',
			self::ARRIVAL => 'Груз прибыл',
			self::GIVE_OUT => 'Груз выдан',
		};

	}


}

