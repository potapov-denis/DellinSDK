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

declare (strict_types=1);

namespace Yooogi\DellinSDK\Endpoints\Book\Requests;

use Yooogi\DellinSDK\Core\Arrayable;
use Yooogi\DellinSDK\Core\Traits\DataAware;
use Yooogi\DellinSDK\Core\Traits\Login;
use function func_get_args;

final class BookCounterAgentsRequest implements Arrayable
{
	use DataAware, Login;

	private ?bool $withAnonym;
	private ?bool $isAnonym;
	private ?array $counteragentIds;

	/**
	 * Список контрагентов из адресной книги
	 *
	 */
	public function __construct(bool $withAnonym = null, bool $isAnonym = null, array $counteragentIds = null)
	{
		$this->setWithAnonym($withAnonym);
		$this->setIsAnonym($isAnonym);
		$this->setCounteragentIds($counteragentIds);
	}

	/**
	 * Список контрагентов из адресной книги
	 *
	 */
	public static function create(): BookCounterAgentsRequest
	{
		return new BookCounterAgentsRequest(...func_get_args());
	}

	/**
	 * Признак запроса списка контрагентов, включающего 'анонимных' получателей
	 *
	 * @return bool|null
	 */
	public function getWithAnonym(): ?bool
	{
		return $this->withAnonym;
	}

	/**
	 * Признак запроса списка контрагентов, включающего 'анонимных' получателей
	 * По умолчанию false
	 *
	 * @param bool|null $withAnonym
	 *
	 * @return BookCounterAgentsRequest
	 */
	public function setWithAnonym(?bool $withAnonym): BookCounterAgentsRequest
	{
		$this->withAnonym = $withAnonym;
		return $this;
	}

	/**
	 * Признак запроса списка контрагентов, включающего только 'анонимных' получателей
	 * По умолчанию false
	 *
	 * @return bool|null
	 */
	public function getIsAnonym(): ?bool
	{
		return $this->isAnonym;
	}

	/**
	 * Признак запроса списка контрагентов, включающего только 'анонимных' получателей
	 * По умолчанию false
	 *
	 * @param bool|null $isAnonym
	 *
	 * @return BookCounterAgentsRequest
	 */
	public function setIsAnonym(?bool $isAnonym): BookCounterAgentsRequest
	{
		$this->isAnonym = $isAnonym;
		return $this;
	}

	/**
	 * Список ID контрагентов, по которым необходима информация.
	 *
	 * @return array|null
	 */
	public function getCounteragentIds(): ?array
	{
		return $this->counteragentIds;
	}

	/**
	 * Список ID контрагентов, по которым необходима информация.
	 *
	 * @param array|null $counteragentIds
	 *
	 * @return BookCounterAgentsRequest
	 */
	public function setCounteragentIds(?array $counteragentIds): BookCounterAgentsRequest
	{
		$this->counteragentIds = $counteragentIds;
		return $this;
	}


	public function toArray(): array
	{
		if ($this->withAnonym) $this->data['withAnonym'] = $this->withAnonym;
		if ($this->isAnonym) $this->data['isAnonym'] = $this->isAnonym;
		if ($this->counteragentIds) $this->data['counteragentIds'] = $this->counteragentIds;

		return $this->data;
	}
}