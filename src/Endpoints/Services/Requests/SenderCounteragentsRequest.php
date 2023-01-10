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

namespace Yooogi\DellinSDK\Endpoints\Services\Requests;

use Yooogi\DellinSDK\Core\Arrayable;
use Yooogi\DellinSDK\Core\Traits\DataAware;
use Yooogi\DellinSDK\Core\Traits\Login;
use function func_get_args;


final class SenderCounteragentsRequest implements Arrayable
{
	use DataAware, Login;

	private ?string $cauid = null;
	private bool $fullInfo = false;

	/**
	 * Запрос контрагентов отправителя
	 *
	 * @return void;
	 */
	public function __construct()
	{
	}

	/**
	 * Запрос контрагентов отправителя
	 *
	 * @return SenderCounteragentsRequest;
	 */

	public static function create(): SenderCounteragentsRequest
	{
		return new self(...func_get_args());
	}

	/**
	 * UID контрагента, от имени которого должны создаваться заявки в рамках текущей сессии.
	 * Параметр позволяет изменить контрагента, выбранного по умолчанию, на другого контрагента
	 *
	 * @return string
	 */
	public function getCauid(): string
	{
		return $this->cauid;
	}

	/**
	 * @param string $cauid
	 *
	 * @return SenderCounteragentsRequest
	 */
	public function setCauid(string $cauid): SenderCounteragentsRequest
	{
		$this->cauid = $cauid;
		return $this;
	}

	/**
	 * Флаг, обозначающий, что запрошена полная информация по контрагентам, а также информация по взаиморасчётам
	 *
	 * @return bool
	 */
	public function isFullInfo(): bool
	{
		return $this->fullInfo;
	}

	/**
	 * Флаг, обозначающий, что запрошена полная информация по контрагентам, а также информация по взаиморасчётам
	 *
	 * @param bool $fullInfo
	 *
	 * @return SenderCounteragentsRequest
	 */
	public function setFullInfo(bool $fullInfo): SenderCounteragentsRequest
	{
		$this->fullInfo = $fullInfo;
		return $this;
	}


	public function toArray(): array
	{
		if ($this->cauid) $this->data['cauid'] = $this->cauid;
		$this->data['fullInfo'] = $this->fullInfo;
		return $this->data;
	}
}
