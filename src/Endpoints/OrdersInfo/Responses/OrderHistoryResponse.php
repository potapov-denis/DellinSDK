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

namespace Yooogi\DellinSDK\Endpoints\OrdersInfo\Responses;

use Yooogi\DellinSDK\Core\Traits\DataAware;
use Yooogi\DellinSDK\Enum\TypeCode;

/**
 * Сервис позволяет получать историю изменений заказов,
 * а также отслеживать статус заявки на внесение изменений.
 * Сервис доступен только авторизованным пользователям.
 *
 * @see https://dev.dellin.ru/api/orders/history/#_header7
 */
final class OrderHistoryResponse
{
	use DataAware;

	private TypeCode $typeCode;
	private string $typeName;
	private \DateTimeImmutable $createdAt;
	private string $status;
	private string $detailedInfo;
	private string $document;

	/**
	 * Тип изменённой информации.
	 *
	 * @return ?TypeCode
	 */
	public function getTypeCode(): ?TypeCode
	{
		if ($this->get('typeCode') !== null) {
			return TypeCode::TryFrom($this->get('typeCode'));
		}

		return null;
	}

	/**
	 * Наименование типа изменённой информации на русском языке.
	 *
	 * @return string|null
	 */
	public function getTypeName(): ?string
	{
		return $this->get('typeName');
	}

	/**
	 * Дата изменения
	 *
	 * @return ?\DateTimeImmutable
	 */
	public function getCreatedAt(): ?\DateTimeImmutable
	{
		return \DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $this->get('createdAt'));
	}

	/**
	 * Статус изменения.
	 *
	 * Возможные значения:
	 *
	 * 'success' - успешно;
	 * 'in_progress' - в процессе;
	 * 'failed' - не успешно
	 *
	 * @return string|null
	 */
	public function getStatus(): ?string
	{
		return $this->get('status');
	}

	/**
	 * Свёрстанная html-страница с подробной информацией о запросе на изменение заказа
	 *
	 * @return string|null
	 */
	public function getDetailedInfo(): ?string
	{
		return $this->get('detailedInfo');
	}

	/**
	 * Ссылка на печатную форму с данными заказа.
	 * Если была изменена контактная информация (значение параметра 'typeCode' - 'contact_info_changes'), то параметр отсутствует в ответе
	 *
	 * @return string|null
	 */
	public function getDocument(): ?string
	{
		return $this->get('document');
	}

	public function toArray(): array
	{
		return $this->data;
	}
}
