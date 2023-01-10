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

namespace Yooogi\DellinSDK\Endpoints\Orders\Entities;

use Yooogi\DellinSDK\Core\Traits\DataAware;
use Yooogi\DellinSDK\Core\Traits\FoundAddressesTrait;
use Yooogi\DellinSDK\Enum\MailCategory;
use Yooogi\DellinSDK\Enum\MailRank;
use Yooogi\DellinSDK\Enum\MailType;
use Yooogi\DellinSDK\Enum\PaymentMethodType;
use Yooogi\DellinSDK\Instantiator;

class Order
{
	use DataAware, FoundAddressesTrait;

	/**
	 * Получение статуса обработки запроса
	 * @return string
	 */
	public function getState(): string
	{
		return (string)$this->get('state');
	}

	/**
	 * Номер созданного предзаказа или заявки
	 * @return int
	 */
	public function getRequestId(): int
	{
		return (int)$this->get('requestID');
	}

	/**
	 * Barcode для формирования штрихкода по алгоритму Code 128, если оформлен предзаказ (то есть, если значение параметра запроса 'delivery.derival.variant' - 'terminal')
	 * @return string|null
	 */
	public function getBarcode(): ?string
	{
		return $this->get('barcode');
	}

	/**
	 * Получение информации о сохранении данных в адресную книгу.
	 * Если пользователь не авторизован, то параметр отсутствует в ответе
	 * @return AddressBook|null
	 */
	public function getAddressBook(): ?AddressBook
	{
		return Instantiator::instantiate(AddressBook::class, $this->get('addressBook'));
	}

	public function toArray(): array
	{
		return $this->data;
	}
}
