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
 * Сопроводительные документы
 *
 * Возможна передача обоих значений с использованием отдельных параметров.
 * Возврат сопроводительных документов недоступен при отправке груза 'анонимному' получателю, то есть, если значение 'members.receiver.counteragent.isAnonym' - 'true'.
 * 'Анонимный' получатель - получатель, о котором предоставлен минимум информации (см. описание услуги 'Упрощённая отправка груза' на сайте компании 'Деловые Линии')
 *
 * @see https://dev.dellin.ru/api/calculation/calculator/#_header10
 */
enum AcDoc: string
{
	/* Cтоимость отправки сопроводительных документов */
	case SEND = 'send';

	/* Cтоимость Получения сопроводительных документов */
	case RETURN = 'return';

	public static function getEnum()
	{
		return static::class;
	}
}

