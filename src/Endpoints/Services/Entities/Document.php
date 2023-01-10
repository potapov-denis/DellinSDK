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

use Yooogi\DellinSDK\Core\Traits\DataAware;
use Yooogi\DellinSDK\Enum\DocumentType;

/**
 *
 * Полная информация о контрагентах.
 *
 * Параметр присутствует в ответе, только если в запросе метода был передан параметр 'fullInfo' со значением 'true'
 *
 * @see https://dev.dellin.ru/api/auth/counteragents/#_header13
 */
final class Document
{
	use DataAware;

	/**
	 *
	 * Тип документа
	 *
	 * Возможные значения:
	 *
	 * 'passport' - паспорт;
	 * 'drivingLicence' - водительское удостоверение;
	 * 'foreignPassport' - заграничный паспорт
	 *
	 * @return DocumentType|null
	 */
	public function getType(): ?DocumentType
	{
		return DocumentType::tryFrom($this->get('type'));
	}

	/**
	 * Серия документа
	 * @return string|null
	 */
	public function getSerial(): ?string
	{
		return $this->get('serial');
	}

	/**
	 * Номер документа. Формат номера зависит от страны
	 * @return string|null
	 */
	public function getNumber(): ?string
	{
		return $this->get('number');
	}

	public function toArray(): array
	{
		return $this->data;
	}

}
