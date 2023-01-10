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

namespace Yooogi\DellinSDK\Endpoints\OrdersInfo\Requests;

use Yooogi\DellinSDK\Core\Arrayable;
use Yooogi\DellinSDK\Core\Traits\DataAware;
use Yooogi\DellinSDK\Core\Traits\Login;

final class OrderPrintRequest implements Arrayable
{
	use DataAware, Login;

	/** @var string $requestID ID документа */
	protected string $requestID;

	/**
	 * Запрос печатных форм
	 *
	 * @param string $requestID ID документа
	 */
	public function __construct(string $requestID)
	{
		$this->setRequestID($requestID);
	}

	/**
	 * Запрос печатных форм
	 *
	 * @param string $requestID ID документа
	 *
	 * @see DataAware;
	 */

	public static function create(string $requestID)
	{
		return new self(...\func_get_args());
	}

	/**
	 * Получить ID документа
	 *
	 * @return string
	 */
	public function getRequestID(): string
	{
		return $this->requestID;
	}

	/**
	 * Установить ID документа;
	 *
	 * @param string $requestID
	 */
	public function setRequestID(string $requestID): void
	{
		$this->requestID = $requestID;
	}

	public function toArray(): array
	{
		$this->data['requestID'] = $this->requestID;
		$this->data['requestsfID'] = $this->requestID;

		return $this->data;
	}

}
