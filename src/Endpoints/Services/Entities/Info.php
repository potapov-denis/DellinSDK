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

namespace Yooogi\DellinSDK\Endpoints\Services\Entities;

use Yooogi\DellinSDK\Core\ArrayOf;
use Yooogi\DellinSDK\Core\Traits\DataAware;
use Yooogi\DellinSDK\Enum\MailCategory;
use Yooogi\DellinSDK\Enum\MailRank;
use Yooogi\DellinSDK\Enum\MailType;
use Yooogi\DellinSDK\Enum\PaymentMethodType;
use Yooogi\DellinSDK\Instantiator;

/**
 *
 * Полная информация о контрагентах.
 *
 * Параметр присутствует в ответе, только если в запросе метода был передан параметр 'fullInfo' со значением 'true'
 *
 * @see https://dev.dellin.ru/api/auth/counteragents/#_header13
 */
final class Info
{
	use DataAware;

	/**
	 * @return int|null
	 */
	public function getAccessLevel(): ?int
	{
		return $this->get('accessLevel');
	}

	/**
	 * Комментарий при отклонении доступа
	 * @return string|null
	 */
	public function getRequestComment(): ?string
	{
		return $this->get('requestComment');
	}

	/**
	 * Электронная почта менеджера клиента
	 * @return string|null
	 */
	public function getManagerEmail(): ?string
	{
		return $this->get('managerEmail');
	}

	/**
	 * Контактный телефон менеджера клиента
	 * @return string|null
	 */
	public function getManagerPhone(): ?string
	{
		return $this->get('managerPhone');
	}

	/**
	 *    ФИО менеджера клиента
	 * @return string|null
	 */
	public function getManagerName(): ?string
	{
		return $this->get('managerName');
	}

	/**
	 * Данные пользователей, которым предоставлен доступ к учетной записи ЛК
	 * @return Shared[]|null
	 */
	public function getSharedTo(): ?array
	{
		return Instantiator::instantiate(new ArrayOf(Shared::class), $this->get('sharedTo'));

	}

	/**
	 * Данные пользователя, который предоставил доступ к учетной записи ЛК
	 * @return Shared[]|null
	 */
	public function getSharedFrom(): ?array
	{
		return Instantiator::instantiate(new ArrayOf(Shared::class), $this->get('sharedFrom'));
	}

	public function toArray(): array
	{
		return $this->data;
	}

}
