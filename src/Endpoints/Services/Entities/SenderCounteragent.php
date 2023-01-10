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
use Yooogi\DellinSDK\Instantiator;

final class SenderCounteragent
{
	use DataAware;


	/**
	 * Признак выбранного контрагента.
	 *
	 * Если в запросе был передан параметр 'cauid', то в ответе у контрагента, UID которого был передан в запросе, значение параметра 'isCurrent' будет равно 'true'
	 * @return bool
	 */
	public function isCurrent(): bool
	{
		return (bool)$this->get('isCurrent');
	}

	/**
	 * Уникальный идентификатор контрагента
	 * @return string|null
	 */
	public function getUid(): ?string
	{
		return $this->get('uid');
	}

	/**
	 * Признак юридического лица
	 *
	 * Возможные значения:
	 *
	 * 'true' - юридическое лицо;
	 * 'false' - физическое лиц.
	 * Параметр присутствует в ответе, только если в запросе метода был передан параметр 'fullInfo' со значением 'true'
	 * @return bool
	 */
	public function isJuridical(): bool
	{
		return (bool)$this->get('juridical');
	}

	/**
	 * ИНН (для юридических лиц), если контрагент является физическим лицом (значение параметра 'juridical' - 'false'), то значение параметра - null.
	 *
	 * Параметр присутствует в ответе, только если в запросе метода был передан параметр 'fullInfo' со значением 'true'
	 *
	 * @return string|null
	 */
	public function getInn(): ?string
	{
		return $this->get('inn');
	}

	/**
	 * Данные документа, удостоверяющего личность (для физических лиц), если контрагент является юридическим лицом (значение параметра 'juridical' - 'true'), то значение параметра - null.
	 *
	 * Параметр присутствует в ответе, только если в запросе метода был передан параметр 'fullInfo' со значением 'true'
	 * Имя/наименование контрагента
	 * @return string|null
	 */
	public function getName(): ?string
	{
		return $this->get('name');
	}

	/**
	 * Признак возможности оформления контрагентом заказа с наложенным платежом
	 * @return bool
	 */
	public function isCashOnDeliveryAvailable(): bool
	{
		return (bool)$this->get('cashOnDeliveryAvailable');
	}


	/**
	 * Информация о движении денежных средств контрагента. Если взаиморасчетов не производилось, значение параметра - null.
	 *
	 * Параметр присутствует в ответе, только если в запросе метода был передан параметр 'fullInfo' со значением 'true'
	 *
	 * @return Balance|null
	 */
	public function getBalance(): ?Balance
	{
		return Instantiator::instantiate(Balance::class, $this->get('balance'));
	}

	/**
	 *
	 * Полная информация о контрагентах.
	 *
	 * Параметр присутствует в ответе, только если в запросе метода был передан параметр 'fullInfo' со значением 'true'
	 *
	 * @see https://dev.dellin.ru/api/auth/counteragents/#_header13
	 */

	public function getInfo(): ?Info
	{
		return Instantiator::instantiate(Info::class, $this->get('info'));
	}

	/**
	 * Данные документа, удостоверяющего личность (для физических лиц), если контрагент является юридическим лицом (значение параметра 'juridical' - 'true'), то значение параметра - null.
	 *
	 * Параметр присутствует в ответе, только если в запросе метода был передан параметр 'fullInfo' со значением 'true'
	 * @see https://dev.dellin.ru/api/auth/counteragents/#_header13
	 *
	 */

	public function getDocument(): ?Document
	{
		return Instantiator::instantiate(Document::class, $this->get('document'));
	}

	public function toArray(): array
	{
		return $this->data;
	}

}
